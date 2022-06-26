import teaserTwig from './teaser.twig';
import teaserData from './teaser.yml';

export default {
  title: 'Molecules/Teaser',
};

export const Teaser = () => teaserTwig(teaserData);
