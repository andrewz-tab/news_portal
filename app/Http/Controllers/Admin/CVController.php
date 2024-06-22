<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\CV\Service;
use App\Models\CV;
use Illuminate\Http\Request;

class CVController extends Controller
{
    public $service;
    public function __construct(Service $service)
    {
        $this->service = $service;
    }
    public function accept(CV $cv)
    {
        $this->authorize('accept', CV::class);
        $this->service->accept($cv, auth()->user());
        return redirect()->route('admin.cvs.index')->with('success', 'Заявка одобрена');;
    }
    public function destroy(CV $cv)
    {
        $this->authorize('delete', $cv);
        $this->service->delete($cv);
        return redirect()->route('admin.cvs.index')->with('success', 'Резюме успешно удалено');
    }
    public function index()
    {
        $cvs = CV::paginate(10);
        return view('admin_panel.cv.index', compact('cvs'));
    }
    public function refuse(CV $cv)
    {
        $this->authorize('refuse', CV::class);
        $this->service->refuse($cv, auth()->user());
        return redirect()->route('admin.cvs.index')->with('success', 'Заявка отклонена');;
    }
    public function show(CV $cv)
    {
        return view('admin_panel.cv.show', compact('cv'));
    }
    
}
