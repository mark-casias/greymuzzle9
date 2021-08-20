import aimh from './aimh-card.twig';

import aimhData from './aimh-data.yml';

export default {
  title: 'Teasers/Always In My Heart',
  parameters: {
    layout: 'centered',
  },
};

export const alwaysInMyHeart = () => aimh(aimhData);
