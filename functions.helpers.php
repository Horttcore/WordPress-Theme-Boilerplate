<?php
/**
 * ------------------------------------------------------------------------------
 * Helper functions
 * ------------------------------------------------------------------------------
 */
function inlineSvgAttachment(int $attachmentId): string
{
    $type = get_post_mime_type($attachmentId);
    if ('image/svg+xml' != $type) {
        return '';
    }

    return inlineSvg(get_attached_file($attachmentId));
}

function inlineSvg(string $file): string
{
    return file_get_contents($file);
}
