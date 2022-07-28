import teaserTwig from './aimh-teaser.twig';
import teaserData from './aimh-teaser.yml';

export default {
  title: 'Teasers/Always In My Heart Teaser',
};

export const AlwaysInMyHeartTeaser = () => teaserTwig(teaserData);
