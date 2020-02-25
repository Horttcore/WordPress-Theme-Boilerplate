<?php
/**
 * ------------------------------------------------------------------------------
 * Helper functions
 * ------------------------------------------------------------------------------
 */
function inlineSvg(int $attachmentId): string
{
    $type = get_post_mime_type($attachmentId);
    if ( 'image/svg+xml' != $type )
        return '';

    return file_get_contents(get_attached_file($attachmentId));
}
