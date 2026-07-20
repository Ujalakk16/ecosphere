<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use App\Helpers\TranslationHelper;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use App\Models\Activity;




class ProductController extends Controller
{
    /**
     * Display the homepage with all products.
     */


public function index(Request $request)
{
    // 1. Language select karein (Session se, default 'en')
    $lang = Session::get('locale', 'en');
    // 1. Base query define karein
    $query = Product::query();

    // 2. Filter aur Search Logic (sabke liye same rahega)
    if ($request->filled('filter')) {
        $query->where('is_elastic', $request->filter === 'elastic');
    }
    if ($request->filled('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    $products = $query->paginate(12)->withQueryString(); 

$tr = new GoogleTranslate($lang);

foreach ($products as $product) {
    // Cache key mein 'product_id' aur 'lang' ka use karein
    $product->name = Cache::remember("prod_name_{$product->id}_{$lang}", 86400, function () use ($tr, $product) {
        return $tr->translate($product->name);
    });

    $product->description = Cache::remember("prod_desc_{$product->id}_{$lang}", 86400, function () use ($tr, $product) {
        return $tr->translate($product->description);
    });
}
    
    // Sidebar Counts (Admin dashboard mein bhi chahiye honge)
    $inelasticCount = Product::where('is_elastic', false)->count();
    $elasticCount = Product::where('is_elastic', true)->count();

    // --- SMART LOGIC ---
    // Agar URL mein 'admin' hai, toh admin view return karo
   if ($request->is('admin/*')) {
    $products = Product::all();
    
            $lang = Session::get('locale', 'en'); // Default language 'en'
    $tr = new GoogleTranslate($lang);
    
    foreach ($products as $product) {
        $product->name = $tr->translate($product->name);
    }
            return view('admin.dashboard', [
                'products' => $products, // Yahi variable view mein loop hoga
                'totalCount' => Product::count(),
                'userCount' => User::count(),
                'inelasticCount' => $inelasticCount,
                'elasticCount' => $elasticCount
            ]);

        
        }
      

       $totalCount = Product::count();
       $userCount = User::count();
    // Warna normal user ko homepage dikhao
    return view('welcome', compact('products', 'inelasticCount', 'elasticCount','totalCount','userCount'));
}
  public function show($id)
{
    $product = Product::findOrFail($id);
    
    // Agar views increase karne hain
    $product->increment('views_today'); 

   // Auth facade use karne se red line nahi aayegi
    if (Auth::check()) {
        Activity::create([
            'user_id' => Auth::id(),
            'action' => 'Viewed product: ' . $product->name,
        ]);
    }
    
    return view('products.show', compact('product'));
}
    public function purchase($id)
{
    $product = Product::findOrFail($id);

    if ($product->stock > 0) {
        // Stock kam karein
        $product->stock -= 1;

        // Scarcity Logic: Jab stock kam hota hai, price jumps up!
        // Elastic ho ya Inelastic, kam stock matlab price hike!
        $product->price += ($product->price * 0.05); 
        
        $product->save();
        return back()->with('success', 'Purchase successful! Market reaction recorded.');
    }

    return back()->with('error', 'Out of stock!');
}
public function analytics()
{
    // Sabse zyada views wale products ya sabse mehenge products nikalne ke liye
    $products = Product::orderBy('price', 'desc')->get();
    return view('products.analytics', compact('products'));
}
/**
     * Add a product to the cart and simulate demand shift.
     */
    public function addToCart($id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        // Agar product pehle se cart me hai toh quantity barha dein
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            // Naya item add karein
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image
            ];
        }
        session()->put('cart', $cart);

        // ====== ADVANCED ECONOMICS LOGIC ======
        // Cart me daalne se 'Intent to Buy' bohot high ho jati hai.
        // Elastic (Luxury) goods par sirf +0.3% price hike (sensitive market)
        // Inelastic (Necessity) goods par +1.2% aggressive price hike (majboori market)
        $hikeRate = $product->is_elastic ? 0.003 : 0.012;
        $product->price += ($product->price * $hikeRate);
        
        // Cart interaction se total demand weight barh gaya
        $product->views_today += 3; 
        $product->save();

        return redirect()->back()->with('success', 'Added to cart! Price updated based on market elasticity.');
    }

   
  public function viewCart()
{
    $cart = session()->get('cart', []);
    return view('products.cart', compact('cart'));
}
public function simulate(Product $product)
{
    // Views increment
    $product->views_today += rand(1, 10);

    // Elasticity logic: Luxuries (Elastic) have higher volatility
    $drift = $product->is_elastic ? rand(-50, 50) : rand(-10, 10);
    
    // Price update
    $product->price += ($product->price * $drift / 100);
    
    // Price ko kabhi bhi 0 se kam na hone dein
    $product->price = max(1, $product->price);

    $product->save();

    return back()->with('success', 'Market fluctuations applied to ' . $product->name);
}
public function remove($id)
{
    $cart = session()->get('cart');
    if(isset($cart[$id])) {
        unset($cart[$id]);
        session()->put('cart', $cart);
    }
    return redirect()->back()->with('success', 'Product removed successfully!');
}


public function checkout(Request $request)
{
    // 1. Stripe API Key set karein
   Stripe::setApiKey(config('services.stripe.secret'));

    // 2. Apne Cart ka Total nikalen (e.g., $582.33)
    // $cartItems = Cart::content(); 
    $totalAmount = 582.33; // Ye value aapke cart calculation se aani chahiye

    // 3. Stripe Checkout Session create karein
    $session = StripeSession::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => 'usd',
                'product_data' => [
                    'name' => 'Ecosphere Order',
                ],
                'unit_amount' => (int) round($totalAmount * 100), // Stripe cents mein leti hai
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => route('checkout.success'),
        'cancel_url' => route('cart.products'),
    ]);

    // 4. User ko Stripe ke page par bhej dein
    return redirect()->away($session->url);
}


// --- ADMIN CRUD FUNCTIONS ---

    public function create() {
        return view('products.create');
    }

   public function store(Request $request) {
  
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        'image' => 'nullable|url', // URL expect kar rahe hain
        'is_elastic' => 'nullable|boolean'
    ]);

    // Agar image URL diya gaya hai
    // if ($request->filled('image')) {
    //     $validated['image'] = $request->image;
    // }
    $validated['category_id'] = $request->category_id ?? 1; // Default category_id set kar dein agar nahi diya gaya
    Product::create($validated);

    return redirect()->route('admin.products')->with('success', 'Product added successfully!');
    

}
   public function edit(Product $product) 
    {
        return view('products.edit', compact('product'));
    }

public function update(Request $request, Product $product) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        'image' => 'nullable|url',
        'is_elastic' => 'nullable|boolean'
    ]);

    // Agar image URL field mein data hai, toh update karein
    if ($request->filled('image')) {
        $validated['image'] = $request->image;
    }

    $product->update($validated);

    return redirect()->route('admin.products')->with('success', 'Product updated successfully!');
}

    public function destroy(Product $product) {
        $product->delete();
        return back()->with('success', 'Product deleted!');
    }
 
public function users() {
    $users = User::all();
    return view('admin.users', compact('users'));
  

}
}