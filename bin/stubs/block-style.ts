import type { ThemeJson } from '../../theme.d.js';

const blockStyle: ThemeJson & {
  title: string;
  blockTypes: string[];
} = {
  "$schema": "https://schemas.wp.org/trunk/theme.json",
  version: 3,
  title: "Title",
  blockTypes: [
    "namespace/block"
  ],
  settings: {},
  styles: {}
};

export default blockStyle;
