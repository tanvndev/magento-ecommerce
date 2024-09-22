<?php

namespace App\Http\Controllers\Api\V1\Slider;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Slider\StoreSliderRequest;
use App\Http\Requests\Slider\UpdateSliderRequest;
use App\Http\Resources\Slider\SliderCollection;
use App\Http\Resources\Slider\SliderResource;
use App\Repositories\Interfaces\Slider\SliderRepositoryInterface;
use App\Services\Interfaces\Slider\SliderServiceInterface;

class SliderController extends Controller
{
    protected $sliderService;

    protected $sliderRepository;

    public function __construct(
        SliderServiceInterface $sliderService,
        SliderRepositoryInterface $sliderRepository
    ) {
        $this->sliderService = $sliderService;
        $this->sliderRepository = $sliderRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paginator = $this->sliderService->paginate();
        $data = new SliderCollection($paginator);

        return successResponse('', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSliderRequest $request)
    {
        $response = $this->sliderService->create();

        return handleResponse($response, ResponseEnum::CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $slider = new SliderResource($this->sliderRepository->findById($id));

        return successResponse('', $slider);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSliderRequest $request, string $id)
    {
        $response = $this->sliderService->update($id);

        return handleResponse($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->sliderService->destroy($id);

        return handleResponse($response);
    }

    // CLIENT API //

    public function getAllSlider()
    {
        $paginator = $this->sliderService->getAllSlider();

        $data = new SliderCollection($paginator);

        return successResponse('', $data);
    }
}
