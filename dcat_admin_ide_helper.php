<?php

/**
 * A helper file for Dcat Admin, to provide autocomplete information to your IDE
 *
 * This file should not be included in your code, only analyzed by your IDE!
 *
 * @author jqh <841324345@qq.com>
 */
namespace Dcat\Admin {
    use Illuminate\Support\Collection;

    /**
     * @property Grid\Column|Collection id
     * @property Grid\Column|Collection name
     * @property Grid\Column|Collection type
     * @property Grid\Column|Collection version
     * @property Grid\Column|Collection detail
     * @property Grid\Column|Collection created_at
     * @property Grid\Column|Collection updated_at
     * @property Grid\Column|Collection is_enabled
     * @property Grid\Column|Collection parent_id
     * @property Grid\Column|Collection order
     * @property Grid\Column|Collection icon
     * @property Grid\Column|Collection uri
     * @property Grid\Column|Collection extension
     * @property Grid\Column|Collection permission_id
     * @property Grid\Column|Collection menu_id
     * @property Grid\Column|Collection slug
     * @property Grid\Column|Collection http_method
     * @property Grid\Column|Collection http_path
     * @property Grid\Column|Collection role_id
     * @property Grid\Column|Collection user_id
     * @property Grid\Column|Collection value
     * @property Grid\Column|Collection username
     * @property Grid\Column|Collection password
     * @property Grid\Column|Collection avatar
     * @property Grid\Column|Collection remember_token
     * @property Grid\Column|Collection province
     * @property Grid\Column|Collection province_id
     * @property Grid\Column|Collection city
     * @property Grid\Column|Collection city_id
     * @property Grid\Column|Collection area
     * @property Grid\Column|Collection area_id
     * @property Grid\Column|Collection price
     * @property Grid\Column|Collection status
     * @property Grid\Column|Collection uuid
     * @property Grid\Column|Collection connection
     * @property Grid\Column|Collection queue
     * @property Grid\Column|Collection payload
     * @property Grid\Column|Collection exception
     * @property Grid\Column|Collection failed_at
     * @property Grid\Column|Collection path
     * @property Grid\Column|Collection imagetable_id
     * @property Grid\Column|Collection imagetable_type
     * @property Grid\Column|Collection sort
     * @property Grid\Column|Collection no
     * @property Grid\Column|Collection shop_id
     * @property Grid\Column|Collection position_id
     * @property Grid\Column|Collection start_date
     * @property Grid\Column|Collection end_date
     * @property Grid\Column|Collection day_range
     * @property Grid\Column|Collection start_time
     * @property Grid\Column|Collection end_time
     * @property Grid\Column|Collection urgent
     * @property Grid\Column|Collection amount
     * @property Grid\Column|Collection wage
     * @property Grid\Column|Collection meal
     * @property Grid\Column|Collection age
     * @property Grid\Column|Collection sex
     * @property Grid\Column|Collection content
     * @property Grid\Column|Collection total
     * @property Grid\Column|Collection paid_at
     * @property Grid\Column|Collection extra
     * @property Grid\Column|Collection email
     * @property Grid\Column|Collection token
     * @property Grid\Column|Collection tokenable_type
     * @property Grid\Column|Collection tokenable_id
     * @property Grid\Column|Collection abilities
     * @property Grid\Column|Collection last_used_at
     * @property Grid\Column|Collection trade_id
     * @property Grid\Column|Collection relate_id
     * @property Grid\Column|Collection cert
     * @property Grid\Column|Collection cert_no
     * @property Grid\Column|Collection cert_title
     * @property Grid\Column|Collection photo
     * @property Grid\Column|Collection real_name
     * @property Grid\Column|Collection ID_card_no
     * @property Grid\Column|Collection address
     * @property Grid\Column|Collection phone
     * @property Grid\Column|Collection wallet
     * @property Grid\Column|Collection sequence
     * @property Grid\Column|Collection batch_id
     * @property Grid\Column|Collection family_hash
     * @property Grid\Column|Collection should_display_on_index
     * @property Grid\Column|Collection entry_uuid
     * @property Grid\Column|Collection tag
     * @property Grid\Column|Collection ancestor
     * @property Grid\Column|Collection descendant
     * @property Grid\Column|Collection distance
     * @property Grid\Column|Collection birthday
     * @property Grid\Column|Collection weixin_openid
     * @property Grid\Column|Collection weapp_openid
     * @property Grid\Column|Collection weixin_unionid
     * @property Grid\Column|Collection subscribe
     * @property Grid\Column|Collection vip
     * @property Grid\Column|Collection complete
     * @property Grid\Column|Collection last_actived_at
     *
     * @method Grid\Column|Collection id(string $label = null)
     * @method Grid\Column|Collection name(string $label = null)
     * @method Grid\Column|Collection type(string $label = null)
     * @method Grid\Column|Collection version(string $label = null)
     * @method Grid\Column|Collection detail(string $label = null)
     * @method Grid\Column|Collection created_at(string $label = null)
     * @method Grid\Column|Collection updated_at(string $label = null)
     * @method Grid\Column|Collection is_enabled(string $label = null)
     * @method Grid\Column|Collection parent_id(string $label = null)
     * @method Grid\Column|Collection order(string $label = null)
     * @method Grid\Column|Collection icon(string $label = null)
     * @method Grid\Column|Collection uri(string $label = null)
     * @method Grid\Column|Collection extension(string $label = null)
     * @method Grid\Column|Collection permission_id(string $label = null)
     * @method Grid\Column|Collection menu_id(string $label = null)
     * @method Grid\Column|Collection slug(string $label = null)
     * @method Grid\Column|Collection http_method(string $label = null)
     * @method Grid\Column|Collection http_path(string $label = null)
     * @method Grid\Column|Collection role_id(string $label = null)
     * @method Grid\Column|Collection user_id(string $label = null)
     * @method Grid\Column|Collection value(string $label = null)
     * @method Grid\Column|Collection username(string $label = null)
     * @method Grid\Column|Collection password(string $label = null)
     * @method Grid\Column|Collection avatar(string $label = null)
     * @method Grid\Column|Collection remember_token(string $label = null)
     * @method Grid\Column|Collection province(string $label = null)
     * @method Grid\Column|Collection province_id(string $label = null)
     * @method Grid\Column|Collection city(string $label = null)
     * @method Grid\Column|Collection city_id(string $label = null)
     * @method Grid\Column|Collection area(string $label = null)
     * @method Grid\Column|Collection area_id(string $label = null)
     * @method Grid\Column|Collection price(string $label = null)
     * @method Grid\Column|Collection status(string $label = null)
     * @method Grid\Column|Collection uuid(string $label = null)
     * @method Grid\Column|Collection connection(string $label = null)
     * @method Grid\Column|Collection queue(string $label = null)
     * @method Grid\Column|Collection payload(string $label = null)
     * @method Grid\Column|Collection exception(string $label = null)
     * @method Grid\Column|Collection failed_at(string $label = null)
     * @method Grid\Column|Collection path(string $label = null)
     * @method Grid\Column|Collection imagetable_id(string $label = null)
     * @method Grid\Column|Collection imagetable_type(string $label = null)
     * @method Grid\Column|Collection sort(string $label = null)
     * @method Grid\Column|Collection no(string $label = null)
     * @method Grid\Column|Collection shop_id(string $label = null)
     * @method Grid\Column|Collection position_id(string $label = null)
     * @method Grid\Column|Collection start_date(string $label = null)
     * @method Grid\Column|Collection end_date(string $label = null)
     * @method Grid\Column|Collection day_range(string $label = null)
     * @method Grid\Column|Collection start_time(string $label = null)
     * @method Grid\Column|Collection end_time(string $label = null)
     * @method Grid\Column|Collection urgent(string $label = null)
     * @method Grid\Column|Collection amount(string $label = null)
     * @method Grid\Column|Collection wage(string $label = null)
     * @method Grid\Column|Collection meal(string $label = null)
     * @method Grid\Column|Collection age(string $label = null)
     * @method Grid\Column|Collection sex(string $label = null)
     * @method Grid\Column|Collection content(string $label = null)
     * @method Grid\Column|Collection total(string $label = null)
     * @method Grid\Column|Collection paid_at(string $label = null)
     * @method Grid\Column|Collection extra(string $label = null)
     * @method Grid\Column|Collection email(string $label = null)
     * @method Grid\Column|Collection token(string $label = null)
     * @method Grid\Column|Collection tokenable_type(string $label = null)
     * @method Grid\Column|Collection tokenable_id(string $label = null)
     * @method Grid\Column|Collection abilities(string $label = null)
     * @method Grid\Column|Collection last_used_at(string $label = null)
     * @method Grid\Column|Collection trade_id(string $label = null)
     * @method Grid\Column|Collection relate_id(string $label = null)
     * @method Grid\Column|Collection cert(string $label = null)
     * @method Grid\Column|Collection cert_no(string $label = null)
     * @method Grid\Column|Collection cert_title(string $label = null)
     * @method Grid\Column|Collection photo(string $label = null)
     * @method Grid\Column|Collection real_name(string $label = null)
     * @method Grid\Column|Collection ID_card_no(string $label = null)
     * @method Grid\Column|Collection address(string $label = null)
     * @method Grid\Column|Collection phone(string $label = null)
     * @method Grid\Column|Collection wallet(string $label = null)
     * @method Grid\Column|Collection sequence(string $label = null)
     * @method Grid\Column|Collection batch_id(string $label = null)
     * @method Grid\Column|Collection family_hash(string $label = null)
     * @method Grid\Column|Collection should_display_on_index(string $label = null)
     * @method Grid\Column|Collection entry_uuid(string $label = null)
     * @method Grid\Column|Collection tag(string $label = null)
     * @method Grid\Column|Collection ancestor(string $label = null)
     * @method Grid\Column|Collection descendant(string $label = null)
     * @method Grid\Column|Collection distance(string $label = null)
     * @method Grid\Column|Collection birthday(string $label = null)
     * @method Grid\Column|Collection weixin_openid(string $label = null)
     * @method Grid\Column|Collection weapp_openid(string $label = null)
     * @method Grid\Column|Collection weixin_unionid(string $label = null)
     * @method Grid\Column|Collection subscribe(string $label = null)
     * @method Grid\Column|Collection vip(string $label = null)
     * @method Grid\Column|Collection complete(string $label = null)
     * @method Grid\Column|Collection last_actived_at(string $label = null)
     */
    class Grid {}

    class MiniGrid extends Grid {}

    /**
     * @property Show\Field|Collection id
     * @property Show\Field|Collection name
     * @property Show\Field|Collection type
     * @property Show\Field|Collection version
     * @property Show\Field|Collection detail
     * @property Show\Field|Collection created_at
     * @property Show\Field|Collection updated_at
     * @property Show\Field|Collection is_enabled
     * @property Show\Field|Collection parent_id
     * @property Show\Field|Collection order
     * @property Show\Field|Collection icon
     * @property Show\Field|Collection uri
     * @property Show\Field|Collection extension
     * @property Show\Field|Collection permission_id
     * @property Show\Field|Collection menu_id
     * @property Show\Field|Collection slug
     * @property Show\Field|Collection http_method
     * @property Show\Field|Collection http_path
     * @property Show\Field|Collection role_id
     * @property Show\Field|Collection user_id
     * @property Show\Field|Collection value
     * @property Show\Field|Collection username
     * @property Show\Field|Collection password
     * @property Show\Field|Collection avatar
     * @property Show\Field|Collection remember_token
     * @property Show\Field|Collection province
     * @property Show\Field|Collection province_id
     * @property Show\Field|Collection city
     * @property Show\Field|Collection city_id
     * @property Show\Field|Collection area
     * @property Show\Field|Collection area_id
     * @property Show\Field|Collection price
     * @property Show\Field|Collection status
     * @property Show\Field|Collection uuid
     * @property Show\Field|Collection connection
     * @property Show\Field|Collection queue
     * @property Show\Field|Collection payload
     * @property Show\Field|Collection exception
     * @property Show\Field|Collection failed_at
     * @property Show\Field|Collection path
     * @property Show\Field|Collection imagetable_id
     * @property Show\Field|Collection imagetable_type
     * @property Show\Field|Collection sort
     * @property Show\Field|Collection no
     * @property Show\Field|Collection shop_id
     * @property Show\Field|Collection position_id
     * @property Show\Field|Collection start_date
     * @property Show\Field|Collection end_date
     * @property Show\Field|Collection day_range
     * @property Show\Field|Collection start_time
     * @property Show\Field|Collection end_time
     * @property Show\Field|Collection urgent
     * @property Show\Field|Collection amount
     * @property Show\Field|Collection wage
     * @property Show\Field|Collection meal
     * @property Show\Field|Collection age
     * @property Show\Field|Collection sex
     * @property Show\Field|Collection content
     * @property Show\Field|Collection total
     * @property Show\Field|Collection paid_at
     * @property Show\Field|Collection extra
     * @property Show\Field|Collection email
     * @property Show\Field|Collection token
     * @property Show\Field|Collection tokenable_type
     * @property Show\Field|Collection tokenable_id
     * @property Show\Field|Collection abilities
     * @property Show\Field|Collection last_used_at
     * @property Show\Field|Collection trade_id
     * @property Show\Field|Collection relate_id
     * @property Show\Field|Collection cert
     * @property Show\Field|Collection cert_no
     * @property Show\Field|Collection cert_title
     * @property Show\Field|Collection photo
     * @property Show\Field|Collection real_name
     * @property Show\Field|Collection ID_card_no
     * @property Show\Field|Collection address
     * @property Show\Field|Collection phone
     * @property Show\Field|Collection wallet
     * @property Show\Field|Collection sequence
     * @property Show\Field|Collection batch_id
     * @property Show\Field|Collection family_hash
     * @property Show\Field|Collection should_display_on_index
     * @property Show\Field|Collection entry_uuid
     * @property Show\Field|Collection tag
     * @property Show\Field|Collection ancestor
     * @property Show\Field|Collection descendant
     * @property Show\Field|Collection distance
     * @property Show\Field|Collection birthday
     * @property Show\Field|Collection weixin_openid
     * @property Show\Field|Collection weapp_openid
     * @property Show\Field|Collection weixin_unionid
     * @property Show\Field|Collection subscribe
     * @property Show\Field|Collection vip
     * @property Show\Field|Collection complete
     * @property Show\Field|Collection last_actived_at
     *
     * @method Show\Field|Collection id(string $label = null)
     * @method Show\Field|Collection name(string $label = null)
     * @method Show\Field|Collection type(string $label = null)
     * @method Show\Field|Collection version(string $label = null)
     * @method Show\Field|Collection detail(string $label = null)
     * @method Show\Field|Collection created_at(string $label = null)
     * @method Show\Field|Collection updated_at(string $label = null)
     * @method Show\Field|Collection is_enabled(string $label = null)
     * @method Show\Field|Collection parent_id(string $label = null)
     * @method Show\Field|Collection order(string $label = null)
     * @method Show\Field|Collection icon(string $label = null)
     * @method Show\Field|Collection uri(string $label = null)
     * @method Show\Field|Collection extension(string $label = null)
     * @method Show\Field|Collection permission_id(string $label = null)
     * @method Show\Field|Collection menu_id(string $label = null)
     * @method Show\Field|Collection slug(string $label = null)
     * @method Show\Field|Collection http_method(string $label = null)
     * @method Show\Field|Collection http_path(string $label = null)
     * @method Show\Field|Collection role_id(string $label = null)
     * @method Show\Field|Collection user_id(string $label = null)
     * @method Show\Field|Collection value(string $label = null)
     * @method Show\Field|Collection username(string $label = null)
     * @method Show\Field|Collection password(string $label = null)
     * @method Show\Field|Collection avatar(string $label = null)
     * @method Show\Field|Collection remember_token(string $label = null)
     * @method Show\Field|Collection province(string $label = null)
     * @method Show\Field|Collection province_id(string $label = null)
     * @method Show\Field|Collection city(string $label = null)
     * @method Show\Field|Collection city_id(string $label = null)
     * @method Show\Field|Collection area(string $label = null)
     * @method Show\Field|Collection area_id(string $label = null)
     * @method Show\Field|Collection price(string $label = null)
     * @method Show\Field|Collection status(string $label = null)
     * @method Show\Field|Collection uuid(string $label = null)
     * @method Show\Field|Collection connection(string $label = null)
     * @method Show\Field|Collection queue(string $label = null)
     * @method Show\Field|Collection payload(string $label = null)
     * @method Show\Field|Collection exception(string $label = null)
     * @method Show\Field|Collection failed_at(string $label = null)
     * @method Show\Field|Collection path(string $label = null)
     * @method Show\Field|Collection imagetable_id(string $label = null)
     * @method Show\Field|Collection imagetable_type(string $label = null)
     * @method Show\Field|Collection sort(string $label = null)
     * @method Show\Field|Collection no(string $label = null)
     * @method Show\Field|Collection shop_id(string $label = null)
     * @method Show\Field|Collection position_id(string $label = null)
     * @method Show\Field|Collection start_date(string $label = null)
     * @method Show\Field|Collection end_date(string $label = null)
     * @method Show\Field|Collection day_range(string $label = null)
     * @method Show\Field|Collection start_time(string $label = null)
     * @method Show\Field|Collection end_time(string $label = null)
     * @method Show\Field|Collection urgent(string $label = null)
     * @method Show\Field|Collection amount(string $label = null)
     * @method Show\Field|Collection wage(string $label = null)
     * @method Show\Field|Collection meal(string $label = null)
     * @method Show\Field|Collection age(string $label = null)
     * @method Show\Field|Collection sex(string $label = null)
     * @method Show\Field|Collection content(string $label = null)
     * @method Show\Field|Collection total(string $label = null)
     * @method Show\Field|Collection paid_at(string $label = null)
     * @method Show\Field|Collection extra(string $label = null)
     * @method Show\Field|Collection email(string $label = null)
     * @method Show\Field|Collection token(string $label = null)
     * @method Show\Field|Collection tokenable_type(string $label = null)
     * @method Show\Field|Collection tokenable_id(string $label = null)
     * @method Show\Field|Collection abilities(string $label = null)
     * @method Show\Field|Collection last_used_at(string $label = null)
     * @method Show\Field|Collection trade_id(string $label = null)
     * @method Show\Field|Collection relate_id(string $label = null)
     * @method Show\Field|Collection cert(string $label = null)
     * @method Show\Field|Collection cert_no(string $label = null)
     * @method Show\Field|Collection cert_title(string $label = null)
     * @method Show\Field|Collection photo(string $label = null)
     * @method Show\Field|Collection real_name(string $label = null)
     * @method Show\Field|Collection ID_card_no(string $label = null)
     * @method Show\Field|Collection address(string $label = null)
     * @method Show\Field|Collection phone(string $label = null)
     * @method Show\Field|Collection wallet(string $label = null)
     * @method Show\Field|Collection sequence(string $label = null)
     * @method Show\Field|Collection batch_id(string $label = null)
     * @method Show\Field|Collection family_hash(string $label = null)
     * @method Show\Field|Collection should_display_on_index(string $label = null)
     * @method Show\Field|Collection entry_uuid(string $label = null)
     * @method Show\Field|Collection tag(string $label = null)
     * @method Show\Field|Collection ancestor(string $label = null)
     * @method Show\Field|Collection descendant(string $label = null)
     * @method Show\Field|Collection distance(string $label = null)
     * @method Show\Field|Collection birthday(string $label = null)
     * @method Show\Field|Collection weixin_openid(string $label = null)
     * @method Show\Field|Collection weapp_openid(string $label = null)
     * @method Show\Field|Collection weixin_unionid(string $label = null)
     * @method Show\Field|Collection subscribe(string $label = null)
     * @method Show\Field|Collection vip(string $label = null)
     * @method Show\Field|Collection complete(string $label = null)
     * @method Show\Field|Collection last_actived_at(string $label = null)
     */
    class Show {}

    /**
     * @method \SuperEggs\DcatDistpicker\Form\Distpicker distpicker(...$params)
     */
    class Form {}

}

namespace Dcat\Admin\Grid {
    /**
     * @method $this distpicker(...$params)
     */
    class Column {}

    /**
     * @method \SuperEggs\DcatDistpicker\Filter\DistpickerFilter distpicker(...$params)
     */
    class Filter {}
}

namespace Dcat\Admin\Show {
    /**
     
     */
    class Field {}
}
