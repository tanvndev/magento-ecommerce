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
use Illuminate\Http\JsonResponse;

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
     * Display a listing of the sliders.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $paginator = $this->sliderService->paginate();
        $data = new SliderCollection($paginator);

        return successResponse('', $data, true);
    }

    /**
     * Store a newly created slider in storage.
     *
     * @param \App\Http\Requests\Slider\StoreSliderRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreSliderRequest $request): JsonResponse
    {
        $response = $this->sliderService->create();

        return handleResponse($response, ResponseEnum::CREATED);
    }

    /**
     * Display the specified slider.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $slider = new SliderResource($this->sliderRepository->findById($id));

        return successResponse('', $slider, true);
    }

    /**
     * Update the specified slider in storage.
     *
     * @param \App\Http\Requests\Slider\UpdateSliderRequest $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateSliderRequest $request, string $id): JsonResponse
    {
        $response = $this->sliderService->update($id);

        return handleResponse($response);
    }

    /**
     * Remove the specified slider from storage.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $response = $this->sliderService->destroy($id);

        return handleResponse($response);
    }

    // CLIENT API //

    /**
     * Get all sliders for clients.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllSlider(): JsonResponse
    {
        $paginator = $this->sliderService->getAllSlider();
        $data = new SliderCollection($paginator);

        return successResponse('', $data, true);
    }
}
