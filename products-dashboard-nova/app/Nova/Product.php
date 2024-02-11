<?php

namespace App\Nova;

use App\Nova\Filters\ProductBrand;
use App\Nova\Metrics\AveragePrice;
use App\Nova\Metrics\NewProducts;
use App\Nova\Metrics\ProductsPerDay;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Product extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Product>
     */
    public static $model = \App\Models\Product::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name'; //customize what should appear oon title when previewing a single product

    public function subtitle()
    {
        return 'Brand: ' . $this->brand->name;
    }

    public static $globalSearchResults = 10;

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name',
        'id',
        'description',
        'sku',
    ];

    public static $perPageOptions = [50, 100, 150]; //how many products should appear

    public static $clickAction = 'edit'; // or select or preview or ignore
    //when clicking on a single product

    // public static $tableStyle = 'tight';

    // public static $showColumnBorders = true;

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            // Slug::make(name: 'Slug of Product', attribute: 'Slug')->from('name')
            Slug::make(name: 'Slug')
                ->from(from: 'name')
                ->required()
                ->hideFromIndex()
                ->textAlign('left')
                ->withMeta([
                    'extraAttributes' => [
                        'readonly' => true
                    ]
                ]),
            Text::make(name: 'Name')
                ->required()
                ->textAlign('left')
                ->placeHolder(text: 'Product name...')
                ->showOnPreview()
                ->sortable(),
            Markdown::make(name: 'Description')
                ->required()
                ->showOnPreview(),
            Number::make(name: 'Price')
                ->required()
                ->textAlign('left')
                ->placeHolder(text: 'Product price...')
                ->showOnPreview()
                ->sortable(),
            Text::make(name: 'Sku')
                ->placeHolder(text: 'Product SKU...')
                ->required()
                ->textAlign('left')
                ->help('Number that retailers use to differenciate products and track inventory levels'),
            Number::make(name: 'Quantity')
                ->required()
                ->textAlign('left')
                ->placeHolder(text: 'Product quantity...')
                ->showOnPreview()
                ->sortable(),
            Boolean::make(name: 'Status', attribute: 'is_published')
                ->required()
                ->textAlign('left')
                ->showOnPreview(),

            BelongsTo::make('Brand')
                ->sortable()
                ->showOnPreview()
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [
            new NewProducts(),
            new AveragePrice(),
            new ProductsPerDay(),
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [
            new ProductBrand(),
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
