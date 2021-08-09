import colors from './colors.twig';

import colorsData from './colors.yml';

import colorsDocs from './colors.mdx';

/**
 * Storybook Definition.
 */
export default {
  title: 'Base/Color Palettes',
  parameters: {
    docs: {
      page: colorsDocs,
    },
  },
};

export const ColorPalettes = () => colors(colorsData);
