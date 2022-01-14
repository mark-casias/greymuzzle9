import card from './program-card.twig';
import cardData from './program-card.yml';
import programDocs from './program-card.mdx';

export default {
  title: 'Media/Program Card',
  parameters: {
    docs: {
      page: programDocs,
    },
    layout: 'centered',
  },
};

export const ProgramCard = () => card(cardData);
