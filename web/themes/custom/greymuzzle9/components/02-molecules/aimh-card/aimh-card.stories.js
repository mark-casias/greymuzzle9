import aimh from './aimh-card.twig';

import aimhData from './aimh-data.yml';

export default {
  title: 'Teasers/Always In My Heart Card',
  parameters: {
    layout: 'centered',
  },
};

export const alwaysInMyHeartCard = () => aimh(aimhData);
