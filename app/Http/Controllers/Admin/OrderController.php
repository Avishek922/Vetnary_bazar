<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\OrderRepositoryInterface;
use App\Http\Requests\OrderRequest;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    protected $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function index(Request $request)
    {
        $query = \App\Models\Order::with('user', 'items.product', 'assignedAgent')->orderBy('created_at', 'desc');

        // Filter for delivery agents - only show assigned orders
        if (in_array(auth()->user()->role, ['delivery_agent', 'delivery'])) {
            $query->where('assigned_to', auth()->id());
        }

        // Search by agent name
        if ($request->filled('agent_search')) {
            $query->whereHas('assignedAgent', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->agent_search . '%');
            });
        }

        $orders = $query->get();
        
        return view('admin.orders.index', compact('orders'));
    }

    public function show(\App\Models\Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, \App\Models\Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $this->orderRepository->updateOrder($order->id, $validated);

        return redirect()->route('admin.orders.show', $order)->with('success', 'Order status updated successfully');
    }

    public function destroy(\App\Models\Order $order)
    {
        if ($order->status !== 'delivered') {
            return redirect()->route('admin.orders.index')->with('error', 'Only delivered orders can be deleted.');
        }

        $this->orderRepository->deleteOrder($order->id);

        return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully');
    }

    public function generateInvoice(\App\Models\Order $order)
    {
        $pdf = Pdf::loadView('admin.orders.invoice', compact('order'));
        return $pdf->download('invoice-' . $order->order_number . '.pdf');
    }

    public function assign(Request $request, \App\Models\Order $order)
    {
        $request->validate([
            'assigned_to' => 'required|exists:users,id',
        ]);

        // Verify the assigned user is a delivery agent
        $agent = \App\Models\User::find($request->assigned_to);
        if (!in_array($agent->role, ['delivery_agent', 'delivery'])) {
            return back()->withErrors(['assigned_to' => 'Selected user is not a delivery agent.']);
        }

        $order->update(['assigned_to' => $request->assigned_to]);

        return back()->with('success', 'Order assigned to ' . $agent->name . ' successfully.');
    }

    public function unassign(\App\Models\Order $order)
    {
        $order->update(['assigned_to' => null]);

        return back()->with('success', 'Order unassigned successfully.');
    }
}
