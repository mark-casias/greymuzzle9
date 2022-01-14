import aimhViewTeaser from './always-in-my-heart-teaser.twig';
import viewData from './view-aimh-teaser.yml';

export default {
  title: 'Views/Always in My Heart Teaser',
};

export const AlwaysInMyHeartTeaser = () => aimhViewTeaser(viewData);
