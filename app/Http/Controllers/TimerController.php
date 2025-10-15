<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Timer;
use Illuminate\Support\Facades\Storage;

class TimerController extends Controller
{

    // Create new timer
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'expiry_datetime' => 'required|date',
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:10240'],
        ]);

        $validated = $request->all();
        // Handle the photo upload
        if ($image = $request->file('image')) {
            $destinationPath = 'storage/timers/';
            // Get the service title and replace spaces with hyphens
            $serviceTitle = str_replace(' ', '-', $validated['title']);

            // Create the image filename with the formatted title and the original file extension
            $timerImage = $serviceTitle . '.' . $image->getClientOriginalExtension();

            // Move the image to the destination path
            $image->move($destinationPath, $timerImage);

            // Store the image name in the $details array
            $validated['image'] = $timerImage;
        }

        Timer::create([
            'title' => $validated['title'],
            'category_id' => $validated['category_id'],
            'expiry_datetime' => $validated['expiry_datetime'],
            'image' => $validated['image'] ?? null,
        ]);

        return back()->with('success', 'Timer created successfully!');
    }


    // Update existing timer
    public function update(Request $request, $id)
    {
        $timer = Timer::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'expiry_datetime' => 'required|date',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($timer->image) {
                Storage::disk('public')->delete($timer->image);
            }
            $validated['image'] = $request->file('image')->store('timers', 'public');
        }

        $timer->update($validated);

        return back()->with('success', 'Timer updated successfully!');
    }

    // Delete timer
    public function destroy($id)
    {
        $timer = Timer::findOrFail($id);

        if ($timer->image) {
            Storage::disk('public')->delete($timer->image);
        }

        $timer->delete();

        return back()->with('success', 'Timer deleted successfully!');
    }
}
