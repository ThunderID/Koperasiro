<?php

namespace Thunderlabid\Registry\Repositories\Specifications;

use Thunderlabid\Registry\Repositories\Specifications\Interfaces\ISpecification;
use Thunderlabid\Registry\Repositories\Specifications\Traits\ISpecificationTrait;
use Exception;

class SpecificationByID implements ISpecification
{
	public function __construct($id)
	{
		////////////////////////////////////////
		// Check if model is instanceof Model //
		////////////////////////////////////////

		$this->specifications['id'] = $id;
	}

	/**
	 * Apply specification
	 * @param  [Model] $model 
	 * @return [Model] $model with applied specification
	 */
	public function apply($model)
	{
		return $model->id($this->specifications['id']);
	}
}
