<?php

	namespace App\Http\Controllers;

	use App\Models\Category;
	use Illuminate\Http\RedirectResponse;
	use Illuminate\Http\Request;

	class CategoryController extends Controller
	{


		/**
		 * Show the form for creating a new resource.
		 */
		public function create()
		{
			//
		}

		/**
		 * Store a newly created resource in storage.
		 */
		public function store(Request $request): RedirectResponse
		{
			// Validate the request data
			$request->validate([
				'name' => ['required', 'string', 'max:255'],
			]);

			// Create a new category
			$category = new Category();
			$category->name = $request->input('name');
			$category->save();

			return redirect()->route('admin.index', ['activeTab' => 'categories'])->with('success', 'Category created successfully.');
		}

		/**
		 * Update the specified resource in storage.
		 */
		public function update(Request $request, Category $category): RedirectResponse
		{
			$request->validate([
				'name' => 'required|string|max:255',
			]);

			// Update the category
			$category->update([
				'name' => $request->input('name'),
			]);

			// Redirect back with success message and tab parameter
			return redirect()->route('admin.index', ['activeTab' => 'categories'])
				->with('success', 'Category updated successfully!');
		}


		/**
		 * Remove the specified resource from storage.
		 */
		public function destroy(Category $category): RedirectResponse
		{
			// Delete the category from the database
			$category->delete();

			return redirect()->route('admin.index')->with('success', 'Category deleted successfully.');
		}

	}
