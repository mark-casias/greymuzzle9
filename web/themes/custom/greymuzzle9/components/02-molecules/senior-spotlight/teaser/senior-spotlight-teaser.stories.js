import teaserTwig from './senior-spotlight-teaser.twig';
import teaserInfo from './senior-spotlight-teaser.yml';

export default {
  title: 'Teasers/Senior Spotlight Teaser',
  argTypes: {
    isAdopted: {
      name: 'Is Adopted?',
      control: { type: 'boolean' },
      defaultValue: true,
    },
  },
};

export const SeniorSpotlightTeaser = ({ isAdopted }) =>
  teaserTwig({
    ...teaserInfo,
    is_adopted: isAdopted,
    content: {
      body: teaserInfo.body,
      teaser_extra_classes: ['wrapper'],
    },
  });
