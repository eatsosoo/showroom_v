<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index()
    {
        return view('admin.leads.index', [
            'title' => 'app.pages.leads',
            'leads' => Lead::with('vehicle')->latest()->paginate(20),
        ]);
    }

    public function show(Lead $lead)
    {
        return view('admin.leads.show', [
            'title' => 'app.pages.lead_detail',
            'lead' => $lead->load('vehicle'),
        ]);
    }

    public function update(Request $request, Lead $lead)
    {
        $data = $request->validate([
            'status' => ['required', 'in:new,contacted,qualified,closed,lost'],
            'admin_note' => ['nullable', 'string'],
        ]);

        $lead->update($data);

        return redirect()->route('admin.leads.show', $lead)->with('success', '膼茫 c岷璸 nh岷璽 lead.');
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();

        return redirect()->route('admin.leads.index')->with('success', '膼茫 x贸a lead.');
    }
}
