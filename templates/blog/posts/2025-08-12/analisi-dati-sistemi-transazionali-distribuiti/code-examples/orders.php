<?php

declare(strict_types=1);

namespace App\DataFrames;

use Flow\ETL\Adapter\Doctrine\DbalMetadata;
use function Flow\ETL\DSL\integer_schema;
use function Flow\ETL\DSL\uuid_schema;
use function Flow\ETL\DSL\datetime_schema;
use function Flow\ETL\DSL\float_schema;
use function Flow\ETL\DSL\string_schema;
use function Flow\ETL\DSL\map_schema;
use function Flow\Types\DSL\type_map;
use function Flow\Types\DSL\type_string;
use function Flow\ETL\DSL\list_schema;
use function Flow\Types\DSL\type_list;
use function Flow\Types\DSL\type_structure;
use function Flow\Types\DSL\type_integer;
use function Flow\Types\DSL\type_float;
use function \Flow\ETL\DSL\schema;
use Flow\ETL\Schema;

final class Orders
{
    public static function sourceSchema() : Schema
    {
        return schema(
            uuid_schema("order_id"),
            uuid_schema("seller_id"),
            datetime_schema("created_at"),
            datetime_schema("updated_at", nullable: true),
            datetime_schema("cancelled_at", nullable: true),
            float_schema("discount", nullable: true),
            string_schema("email"),
            string_schema("customer"),
            map_schema("address", type: type_map(key_type: type_string(), value_type: type_string())),
            list_schema("notes", type: type_list(element: type_string())),
            list_schema("items", type: type_list(element: type_structure(elements: ["item_id" => type_string(), "sku" => type_string(), "quantity" => type_integer(), "price" => type_float()]))),
        );
    }

    public static function destinationSchema() : Schema
    {
        return self::sourceSchema()
            ->replace('updated_at', datetime_schema("updated_at"))
            ->remove('address')
            ->add(
                string_schema('street', metadata: DbalMetadata::length(2048)),
                string_schema('city', metadata: DbalMetadata::length(512)),
                string_schema('zip', metadata: DbalMetadata::length(32)),
                string_schema('country', metadata: DbalMetadata::length(128)),
            )
            ->remove('items')
            ->add(
                uuid_schema('item_id', metadata: DbalMetadata::primaryKey()),
                string_schema('sku', metadata: DbalMetadata::length(64)),
                integer_schema('quantity'),
                integer_schema('price'),
                string_schema('currency', metadata: DbalMetadata::length(3)),
            )
            ;
    }
}