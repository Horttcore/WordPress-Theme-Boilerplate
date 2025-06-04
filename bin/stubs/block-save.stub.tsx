import { useBlockProps } from "@wordpress/block-editor";
import { __ } from "@wordpress/i18n";

const Save = ({ attributes: {}, setAttributes }) => {
    return <div {...useBlockProps.save()}></div>;
};

export default Save;
