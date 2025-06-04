import edit from "./edit";
import save from "./save";
import block from "./block.json";
import { registerBlockType } from "@wordpress/blocks";

/**
 * Register Block
 */
registerBlockType(block, {
    edit,
    save,
});
