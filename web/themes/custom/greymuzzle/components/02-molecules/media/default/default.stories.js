import imageTwig from './default.twig';
import defaultDoc from './default.mdx';

export default {
  title: 'Media/Default',
  parameters: {
    docs: {
      page: defaultDoc,
    },
    layout: 'centered',
  },
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
