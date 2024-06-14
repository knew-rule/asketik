<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coffee;

class CoffeeController extends Controller
{
    public function index(Request $request)
{
    $query = $request->input('query');
    $category = $request->input('category'); // Retrieve selected category from the request

    $coffeesQuery = Coffee::query(); // Start building the query

    if ($category) {
        $coffeesQuery->where('category', $category); // Filter by selected category
    }

    if ($query) {
        $coffeesQuery->where('name', 'like', "%$query%"); // Filter by search query
    }

    $coffees = $coffeesQuery->get(); // Execute the query

    $subPageTitle = 'Explore Our Fresh Selection';
    $pageTitle = 'Coffee Shop';

    return view('ui.coffee.coffee_index', compact(
        'coffees',
        'subPageTitle',
        'pageTitle'
    ));
}
    

    public function create()
    {
        $subPageTitle = 'Craft Your Own Blend'; 
        $pageTitle = 'Create Your Coffee'; 
        return view('ui.coffee.coffee_create', compact(
            'subPageTitle',
            'pageTitle'
        ));
    }
    
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string',
        'price' => 'required|numeric',
        'category' => 'nullable|string',
        'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', 
    ]);

    if ($request->hasFile('image')) {
        $category = $request->input('category') ?? 'uncategorized';
        $name = $request->input('name');
        
        // Construct the directory path
        $directory = "menu/$category/$name";

        // Store the image in the storage directory
        $imagePath = $request->file('image')->store($directory, 'public');

        // Save the path without the 'public/' prefix in the database
        $imagePath = str_replace('public/', '', $imagePath);
    } else {
        $imagePath = null;
    }

    $coffee = new Coffee([
        'name' => $request->input('name'),
        'price' => $request->input('price'),
        'category' => $request->input('category'),
        'image' => $imagePath,
    ]);
    $coffee->save();

    return redirect()->route('coffees.index')->with('success', 'Coffee created successfully.');
}


    

    public function show($id)
    {
        $coffee = Coffee::find($id);
        $subPageTitle = 'Discover More About Our Beans';
        $pageTitle = 'Single Coffee Product';
    
        if (!$coffee) {
            return view('ui.page.404', compact(
                'subPageTitle',
                'pageTitle'
            ));
        }
    
        // Retrieve the category of the main coffee product
        $category = $coffee->category;
    
        // Retrieve related products with the same category
        $relatedProducts = Coffee::where('category', $category)
                                 ->where('id', '!=', $id)
                                 ->inRandomOrder()
                                 ->limit(3)
                                 ->get();
    
        return view('ui.coffee.coffee_show', [
            'coffee' => $coffee,
            'relatedProducts' => $relatedProducts,
            'subPageTitle' => $subPageTitle,
            'pageTitle' => $pageTitle
        ]);
    }
    

    public function edit($id)
    {
        $coffee = Coffee::find($id);
        $subPageTitle = 'Refine Your Brew';
        $pageTitle = 'Edit Coffee'; 
        
        return view('ui.coffee.coffee_edit', compact(
            'coffee',
            'subPageTitle',
            'pageTitle'
        ));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'category' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Allow image to be null
        ]);
    
        $coffee = Coffee::find($id);
    
        if (!$coffee) {
            return redirect()->route('coffees.index')->with('error', 'Coffee not found.');
        }
    
        // If a new image is uploaded, update it
        if ($request->hasFile('image')) {
            $category = $request->input('category') ?? 'uncategorized';
            $name = $request->input('name');
            
            // Construct the directory path
            $directory = "menu/$category/$name";
    
            // Store the image in the storage directory
            $imagePath = $request->file('image')->store($directory, 'public');
    
            // Save the path without the 'public/' prefix in the database
            $imagePath = str_replace('public/', '', $imagePath);
    
            $coffee->image = $imagePath; // Update the image path
        }
    
        // Update other fields
        $coffee->name = $request->input('name');
        $coffee->price = $request->input('price');
        $coffee->category = $request->input('category');
        $coffee->save();
    
        return redirect()->route('coffees.index')->with('success', 'Coffee updated successfully.');
    }
    

    public function destroy($id)
    {
        Coffee::destroy($id);

        return redirect()->route('coffees.index')
            ->with('success', 'Coffee deleted successfully');
    }
}
