<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;


class Seed130 extends Seeder 
{

        /**
     * Run the database seeds.
     *
     * @return
     */
    public function run()
    {
    // Projects
        AdminMenu::create([
            'name' => 'Projects',
            'unique_id' =>'core.content.projects',
            'icon' => 'lo-icon lo-icon-edit',
            'route' => 'content.list',
            'permission' => 'manage-content',
            'order' => 26,
            'params' => [
                'contentTypeSlug' => 'projects'
            ]
        ]);

    // ContentType
        App\Models\Core\Content\ContentType::create([
            'name' => 'Projects',
            'name_singular' => 'Project',
            'slug' => 'projects',
            'front_slug' => 'projects',
            'locked' => true,
            'type' => 2
        ]);

    // Taxonomies
        $typesSettings = [
            'allowCreate'=> true,
            'allowFilterable' => true,
            'allowMultiple' => true,
            'canHaveChildren' => false,
            'maxAllowed' => 1,
            'required' => false
        ];

        $typesTaxonomy = App\Models\Core\Taxonomies\Taxonomy::create([
            'name' => 'Types',
            'name_singular' => 'Type',
            'slug' => 'types',
            'content_type_id' => 3,
            'settings' => $typesSettings
        ]);
    }
}