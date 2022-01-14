import teaserTwig from './senior-spotlight-teaser.twig';

export default {
  title: 'Teasers/Senior Spotlight',
  argTypes: {
    isAdopted: {
      name: 'Is Adopted?',
      control: { type: 'boolean' },
      defaultValue: false,
    },
  },
};

export const SeniorSpotlight = ({ isAdopted }) =>
  teaserTwig({
    content: {
      field_is_adopted: isAdopted,
    },
  });
