import imageTwig from './default.twig';

export default {
  title: 'Media/Default',
  argTypes: {
    photoCredit: {
      name: 'Photo Credit',
      control: { type: 'text' },
      defaultValue: 'Marge Simpson',
    },
  },
};

export const Default = ({ photoCredit }) =>
  imageTwig({
    content: {
      field_photo_credit: [photoCredit],
    },
  });
