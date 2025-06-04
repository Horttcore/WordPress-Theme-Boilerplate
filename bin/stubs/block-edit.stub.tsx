import { BlockEditProps } from "@wordpress/blocks";

const Edit = (props: BlockEditProps<any>) => {
    return <div {...useBlockProps()}>Edit view for __BLOCK_NAME__</div>;
};

export default Edit;
