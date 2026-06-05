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
            'title' => 'Lead khách hàng',
            'leads' => Lead::with('vehicle')->latest()->paginate(20),
        ]);
    }

    public function show(Lead $lead)
    {
        return view('admin.leads.show', [
            'title' => 'Chi tiết lead',
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

        return redirect()->route('admin.leads.show', $lead)->with('success', 'Đã cập nhật lead.');
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();

        return redirect()->route('admin.leads.index')->with('success', 'Đã xóa lead.');
    }
}
