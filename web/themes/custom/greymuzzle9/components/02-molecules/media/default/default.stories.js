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
      field_media_image:
        '<img height="213" width="320" style="width: 320px; height: 213px;" class="media-element file-basic-page-320x240-left" data-delta="1" typeof="foaf:Image" src="https://www.greymuzzle.org/sites/default/files/styles/basic_page_320x240/public/paterno.jpg?itok=aD7GCO2Y" alt="" />',
    },
  });
