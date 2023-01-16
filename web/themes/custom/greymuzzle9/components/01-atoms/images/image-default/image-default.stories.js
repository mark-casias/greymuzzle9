import imageTwig from './image-default.twig';

export default {
  title: 'Atoms/Image/Default',
  argTypes: {
    photoCredit: {
      name: 'Photo Credit',
      control: { type: 'text' },
      defaultValue: 'Hello',
    },
  },
};

export const Default = ({ photoCredit }) =>
  imageTwig({
    content: {
      field_photo_credit: [photoCredit],
      field_caption: 'I am a caption',
    },
  });
