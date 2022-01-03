import imageTwig from './image-default.twig';

export default {
  title: 'Atoms/Image/Default',
  argTypes: {
    photoCredit: {
      name: 'Photo Credit',
      control: { type: 'text' },
      defaultValue: null,
    },
  },
};

export const Default = ({ photoCredit }) =>
  imageTwig({
    content: {
      field_photo_credit: [photoCredit],
    },
  });
