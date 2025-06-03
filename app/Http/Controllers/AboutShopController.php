<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AboutShopController extends Controller
{
    public function edit()
    {
        return view('home.aboutshop.edit');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'who_we_are' => 'required|string|max:1000',
            'commitment_to_you' => 'required|string|max:1000',
            'why_choose_us' => 'required|string|max:1000',
        ]);

        $whyChooseUsArray = explode("\n", $request->input('why_choose_us'));

        $newConfigContent = [
            'who_we_are' => $request->input('who_we_are'),
            'commitment_to_you' => $request->input('commitment_to_you'),
            'why_choose_us' => $whyChooseUsArray,
        ];

        $configContent = "<?php\n\nreturn " . var_export($newConfigContent, true) . ";\n";

        $configPath = config_path('about.php');

        try {
            File::put($configPath, $configContent);
            return redirect()->route('aboutshop')->with('success', 'Content updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while saving changes: ' . $e->getMessage());
        }
    }
}