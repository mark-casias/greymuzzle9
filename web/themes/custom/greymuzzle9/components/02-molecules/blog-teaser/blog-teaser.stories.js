import teaserTwig from './blog-teaser.twig';

export default {
  title: 'Teasers/Blog',
};

const blogData = {
  url: '#',
  label: 'How to Bond with Your Adopted Senior Dog',
};

export const Blog = () => teaserTwig(blogData);
