import teaser from './article-teaser.twig';
import teaserData from './article-teaser.yml';
import teaserDoc from './article-teaser.mdx';

export default {
  title: 'Teasers/Blog Teaser',
  parameters: {
    docs: {
      page: teaserDoc,
    },
  },
};

export const blogTeaser = () => teaser(teaserData);
