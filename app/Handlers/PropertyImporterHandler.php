<?php declare(strict_types = 1);

namespace App\Handlers;

use App\PropertyType;
use App\Values\Result;
use App\Services\TrialApi;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use App\Repositories\PropertyRepository;
use App\Repositories\PropertyTypeRepository;

class PropertyImporterHandler
{

    /**
     * @var array|null
     */
    private ?array $errors;

    /**
     * @var \App\Services\TrialApi
     */
    private $api;

    /**
     * @var \App\Repositories\PropertiesRepository
     */
    private $repository;

    /**
     * @var \App\Repositories\PropertyTypeRepository
     */
    private PropertyTypeRepository $typeRepo;

    /**
     * PropertyImporterHandler constructor.
     *
     * @param \App\Services\TrialApi                   $api
     * @param \App\Repositories\PropertyRepository     $repository
     * @param \App\Repositories\PropertyTypeRepository $typeRepo
     */
    public function __construct(TrialApi $api, PropertyRepository $repository)
    {
        $this->api = $api;
        $this->repository = $repository;
        $this->typeRepo = (new PropertyTypeRepository(new PropertyType()));
    }

    /**
     * @return \App\Values\Result
     */
    public function handle(): Result
    {
        $items = $this->getDataToImport();
        $saved = 0;
        $this->errors = null;
        $start = microtime(true);

        Log::info('Import started');

        foreach ($items as $item) {
            try {
                $this->typeRepo->save($item['property_type']);
                $mapped = $this->map($item);
                $saved += (int) $this->repository->save($mapped);
            } catch (\Throwable $exception) {
                Log::critical($exception->getMessage());
                dd($exception);
                $this->addError($exception);
            }
        }


        $failed = $this->errors ? count($this->errors) : 0;
        $total = count($items);
        $time = microtime(true) - $start;
        $data = compact('failed', 'total', 'saved', 'time');

        if ($failed === $total) {
            Log::error('Report was not successful');

            return new Result('failure', 'The import was not successful', $data);
        }

        if ($failed) {
            Log::error('Import ended with errors');

            return new Result('error', 'The import was not successful. Saved ' . $saved . ' items',
                $data);
        }
        Log::error('Import ended successfully');

        return new Result('success', 'The import was successful for ' . $saved . 'items', $data);
    }

    /**
     * @param $item
     * @return array
     */
    public function map($item): array
    {
        return [
            'uuid' => $item['uuid'],
            'property_type_id' => $item['property_type_id'],
            'county' => $item['county'],
            'country' => $item['country'],
            'town' => $item['town'],
            'description' => $item['description'],
            'address' => $item['address'],
            'image_full' => $item['image_full'],
            'image_thumbnail' => $item['image_thumbnail'],
            'latitude' => $item['latitude'],
            'longitude' => $item['longitude'],
            'num_bedrooms' => $item['num_bedrooms'],
            'num_bathrooms' => $item['num_bathrooms'],
            'price' => $item['price'],
            'type' => $item['type'],
            'last_modified' => $item['updated_at'],
        ];
    }

    /**
     * @return array
     */
    private function getDataToImport(): array
    {
        $page = 1;
        $pagesData = [];
        $data = $this->api->getProperties($page);
        $pages = $data['last_page'];
        $pagesData[$page] = $data['data'];

        for ($i = 2; $i <= $pages; $i++) {
            $pagesData[$i] = $this->api->getProperties($i)['data'];
        }

        return Arr::flatten($pagesData, 1);
    }

    /**
     * @param \Exception $exception
     */
    private function addError(\Exception $exception): void
    {
        $this->errors[] = $exception->getMessage();
    }

}
