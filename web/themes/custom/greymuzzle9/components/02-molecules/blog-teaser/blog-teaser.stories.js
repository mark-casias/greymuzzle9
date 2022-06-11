import teaserTwig from './blog-teaser.twig';

export default {
  title: 'Teasers/Blog Teaser',
};

const blogData = {
  url: '#',
  label: 'How to Bond with Your Adopted Senior Dog',
};

export const BlogTeaser = () => teaserTwig(blogData);
