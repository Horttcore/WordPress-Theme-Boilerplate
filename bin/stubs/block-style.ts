import type { ThemeJson } from '../../../theme.d.js';

const blockStyle: Partial<ThemeJson> & {
  title: string;
  slug: string;
  blockTypes: string[];
} = {
  title: "Title",
  slug: "slug",
  blockTypes: [
    "namespace/block"
  ],
  settings: {},
  styles: {}
};

export default blockStyle;
