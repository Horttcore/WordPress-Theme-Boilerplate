import type { ThemeJson } from '../../../theme.d.js';

const blockStyle: Partial<ThemeJson> & {
  title: string;
  slug: string;
  blockTypes: string[];
} = {
  title: "Section",
  slug: "section",
  blockTypes: [
    "core/group"
  ],
  settings: {},
  styles: {
    "spacing": {
      "padding": {
        "top": "4rem",
        "right": "0",
        "bottom": "4rem",
        "left": "0"
      }
    }
  }
};

export default blockStyle;
