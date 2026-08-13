<?php

namespace App\Services;

use App\Models\ApprovalFlow;
use App\Models\LetterTemplate;
use App\Models\LetterType;

class AdminLetterTypeService
{
    /**
     * Get all letter types with their approval flows, steps, and active template.
     */
    public function getAllLetterTypes()
    {
        return LetterType::with(['approvalFlow.steps', 'activeTemplate'])->latest()->get();
    }

    /**
     * Get a single letter type by ID with relationships.
     */
    public function getLetterTypeById(int $id): LetterType
    {
        return LetterType::with(['approvalFlow.steps', 'activeTemplate'])->findOrFail($id);
    }

    /**
     * Get all available approval flows with steps.
     */
    public function getAllApprovalFlows()
    {
        return ApprovalFlow::with('steps')->get();
    }

    /**
     * Create a new letter type and its associated active template.
     */
    public function createLetterType(array $data): LetterType
    {
        $letterType = LetterType::create([
            'name' => $data['name'],
            'code' => strtoupper($data['code']),
            'description' => $data['description'] ?? null,
            'approval_flow_id' => $data['approval_flow_id'],
            'is_active' => filter_var($data['is_active'] ?? true, FILTER_VALIDATE_BOOLEAN),
            'minimum_gpa' => isset($data['minimum_gpa']) && $data['minimum_gpa'] !== '' ? (float) $data['minimum_gpa'] : null,
            'minimum_credits' => isset($data['minimum_credits']) && $data['minimum_credits'] !== '' ? (int) $data['minimum_credits'] : null,
            'requires_attachment' => filter_var($data['requires_attachment'] ?? false, FILTER_VALIDATE_BOOLEAN),
            'allow_group_submission' => filter_var($data['allow_group_submission'] ?? false, FILTER_VALIDATE_BOOLEAN),
        ]);

        $bodyContent = $data['template_content'] ?? $data['content'] ?? null;

        if (!empty($bodyContent)) {
            LetterTemplate::create([
                'letter_type_id' => $letterType->id,
                'name' => 'Default Active Template - ' . $letterType->name,
                'body_content' => $bodyContent,
                'is_active' => true,
            ]);
        }

        return $letterType;
    }

    /**
     * Update an existing letter type and its active template.
     */
    public function updateLetterType(LetterType $letterType, array $data): LetterType
    {
        $letterType->update([
            'name' => $data['name'],
            'code' => strtoupper($data['code']),
            'description' => $data['description'] ?? null,
            'approval_flow_id' => $data['approval_flow_id'],
            'is_active' => filter_var($data['is_active'] ?? true, FILTER_VALIDATE_BOOLEAN),
            'minimum_gpa' => isset($data['minimum_gpa']) && $data['minimum_gpa'] !== '' ? (float) $data['minimum_gpa'] : null,
            'minimum_credits' => isset($data['minimum_credits']) && $data['minimum_credits'] !== '' ? (int) $data['minimum_credits'] : null,
            'requires_attachment' => filter_var($data['requires_attachment'] ?? false, FILTER_VALIDATE_BOOLEAN),
            'allow_group_submission' => filter_var($data['allow_group_submission'] ?? false, FILTER_VALIDATE_BOOLEAN),
        ]);

        $bodyContent = $data['template_content'] ?? $data['content'] ?? null;

        if (!empty($bodyContent)) {
            $activeTemplate = $letterType->activeTemplate;
            if ($activeTemplate) {
                $activeTemplate->update([
                    'body_content' => $bodyContent,
                ]);
            } else {
                LetterTemplate::create([
                    'letter_type_id' => $letterType->id,
                    'name' => 'Active Template - ' . $letterType->name,
                    'body_content' => $bodyContent,
                    'is_active' => true,
                ]);
            }
        }

        return $letterType;
    }

    /**
     * Delete a letter type and its templates.
     */
    public function deleteLetterType(LetterType $letterType): bool
    {
        LetterTemplate::where('letter_type_id', $letterType->id)->delete();
        return $letterType->delete();
    }
}
