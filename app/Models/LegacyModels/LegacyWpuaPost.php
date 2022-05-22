<?php


namespace App\Models\LegacyModels;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LegacyModels\LegacyWpuaPost
 *
 * @property int $ID
 * @property int $post_author
 * @property string $post_date
 * @property string $post_date_gmt
 * @property string $post_content
 * @property string $post_title
 * @property string $post_excerpt
 * @property string $post_status
 * @property string $comment_status
 * @property string $ping_status
 * @property string $post_password
 * @property string $post_name
 * @property string $to_ping
 * @property string $pinged
 * @property string $post_modified
 * @property string $post_modified_gmt
 * @property string $post_content_filtered
 * @property int $post_parent
 * @property string $guid
 * @property int $menu_order
 * @property string $post_type
 * @property string $post_mime_type
 * @property int $comment_count
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaPost newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaPost newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaPost query()
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaPost whereCommentCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaPost whereCommentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaPost whereGuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaPost whereID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaPost whereMenuOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaPost wherePingStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaPost wherePinged($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaPost wherePostAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaPost wherePostContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaPost wherePostContentFiltered($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaPost wherePostDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaPost wherePostDateGmt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaPost wherePostExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaPost wherePostMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaPost wherePostModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaPost wherePostModifiedGmt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaPost wherePostName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaPost wherePostParent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaPost wherePostPassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaPost wherePostStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaPost wherePostTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaPost wherePostType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaPost whereToPing($value)
 * @mixin \Eloquent
 */
class LegacyWpuaPost extends Model
{
    use HasFactory;
}
