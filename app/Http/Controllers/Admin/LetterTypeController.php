<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLetterTypeRequest;
use App\Http\Requests\UpdateLetterTypeRequest;
use App\Models\LetterType;
use App\Services\AdminLetterTypeService;
use App\Services\TemplateRendererService;
use Illuminate\Http\Request;

class LetterTypeController extends Controller
{
    protected AdminLetterTypeService $letterTypeService;
    protected TemplateRendererService $templateRenderer;

    public function __construct(
        AdminLetterTypeService $letterTypeService,
        TemplateRendererService $templateRenderer
    ) {
        $this->letterTypeService = $letterTypeService;
        $this->templateRenderer = $templateRenderer;
    }

    /**
     * Display a listing of the letter types.
     */
    public function index()
    {
        $letterTypes = $this->letterTypeService->getAllLetterTypes();

        return view('admin.letters.index', compact('letterTypes'));
    }

    /**
     * Show the form for creating a new letter type.
     */
    public function create()
    {
        $approvalFlows = $this->letterTypeService->getAllApprovalFlows();

        return view('admin.letters.create', compact('approvalFlows'));
    }

    /**
     * Store a newly created letter type in storage.
     */
    public function store(StoreLetterTypeRequest $request)
    {
        $this->letterTypeService->createLetterType($request->validated());

        return redirect()->route('admin.letters.index')
            ->with('success', 'Jenis Surat baru berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified letter type.
     */
    public function edit(Request $request, $letterType = null)
    {
        $id = is_object($letterType) ? $letterType->id : ($letterType ?? $request->query('id'));

        if (!$id) {
            $first = LetterType::first();
            $id = $first ? $first->id : abort(404, 'Jenis surat tidak ditemukan.');
        }

        $letterTypeModel = $this->letterTypeService->getLetterTypeById((int) $id);
        $approvalFlows = $this->letterTypeService->getAllApprovalFlows();

        return view('admin.letters.edit', [
            'letterType' => $letterTypeModel,
            'approvalFlows' => $approvalFlows,
        ]);
    }

    /**
     * Update the specified letter type in storage.
     */
    public function update(UpdateLetterTypeRequest $request, $letterType)
    {
        $id = is_object($letterType) ? $letterType->id : ($letterType ?? $request->input('id'));
        $letterTypeModel = $this->letterTypeService->getLetterTypeById((int) $id);

        $this->letterTypeService->updateLetterType($letterTypeModel, $request->validated());

        return redirect()->route('admin.letters.index')
            ->with('success', 'Jenis Surat berhasil diperbarui.');
    }

    /**
     * Preview letter template document with header, body content, signature, and footer.
     */
    public function preview(Request $request, $letterType)
    {
        $id = is_object($letterType) ? $letterType->id : ($letterType ?? $request->query('id'));
        $letterTypeModel = $this->letterTypeService->getLetterTypeById((int) $id);
        
        $bodyContent = optional($letterTypeModel->activeTemplate)->body_content 
            ?? '<div class="doc-title-main">' . e($letterTypeModel->name) . '</div><p>Belum ada isi template surat yang dikonfigurasi.</p>';

        $signatureProps = [
            'city' => 'Yogyakarta',
            'date' => date('d F Y'),
            'title' => 'Ketua Program Studi',
            'department' => 'Prodi D3 Teknik Informatika',
            'name' => 'Dr. Barka Satya, M.Kom',
            'nip' => '190302126',
        ];

        return $this->templateRenderer->renderAdminPreview(
            $bodyContent,
            'Preview Template Surat - ' . $letterTypeModel->name
        );
    }

    /**
     * Remove the specified letter type from storage.
     */
    public function destroy(Request $request, $letterType)
    {
        $id = is_object($letterType) ? $letterType->id : ($letterType ?? $request->input('id'));
        $letterTypeModel = $this->letterTypeService->getLetterTypeById((int) $id);

        $this->letterTypeService->deleteLetterType($letterTypeModel);

        return redirect()->route('admin.letters.index')
            ->with('success', 'Jenis Surat berhasil dihapus.');
    }
}
