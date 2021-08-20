import card from './program-card.twig';
import cardData from './program-card.yml';

export default {
  title: 'Paragraphs/Program Card',
  parameters: {
    layout: 'centered',
  },
};

export const ProgramCard = () => card(cardData);
