<?php

namespace EscolaLms\HeadlessH5P\Dtos;

use EscolaLms\HeadlessH5P\Dtos\Contracts\InstantiateFromRequest;
use EscolaLms\HeadlessH5P\Enums\H5PPermissionsEnum;
use EscolaLms\HeadlessH5P\Repositories\Criteria\Primitives\EqualCriterion;
use EscolaLms\HeadlessH5P\Repositories\Criteria\Primitives\LikeCriterion;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ContentFilterCriteriaDto extends CriteriaDto implements InstantiateFromRequest
{
    public static function instantiateFromRequest(Request $request): self
    {
        $criteria = new Collection();
        $user = auth()->user();

        if ($request->has('title')) {
            $criteria->push(new LikeCriterion('parameters->metadata->title', $request->get('title')));
        }
        if ($user->can(H5PPermissionsEnum::H5P_LIST) && $request->has('author_id')) {
            $criteria->push(new EqualCriterion('hh5p_contents.user_id', $request->input('author_id')));
        }
        if (!$user->can(H5PPermissionsEnum::H5P_LIST) && $user->can(H5PPermissionsEnum::H5P_AUTHOR_LIST)) {
            $criteria->push(new EqualCriterion('hh5p_contents.user_id', $user->getKey()));
        }
        if ($request->has('library_id')) {
            $criteria->push(new EqualCriterion('hh5p_contents.library_id', $request->input('library_id')));
        }

        return new self($criteria);
    }
}
