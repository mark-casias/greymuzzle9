import teaserTwig from './senior-spotlight-teaser.twig';

export default {
  title: 'Teasers/Senior Spotlight Teaser',
  argTypes: {
    isAdopted: {
      name: 'Is Adopted?',
      control: { type: 'boolean' },
      defaultValue: false,
    },
  },
};

export const SeniorSpotlightTeaser = ({ isAdopted }) =>
  teaserTwig({
    content: {
      field_is_adopted: isAdopted,
      teaser_extra_classes: ['wrapper'],
    },
  });
