import cardTwig from './card.twig';
import cardData from './card.yml';

/**
 * Storybook Definition.
 */
export default {
  title: 'Molecules/Cards',
  argTypes: {
    cardType: {
      name: 'Type',
      control: {
        type: 'check',
        options: {
          'grid-item': 'grid-item',
        },
      },
    },
  },
};

export const Cards = ({ cardType }) =>
  cardTwig({
    ...cardData,
    card__modifiers: cardType,
  });
