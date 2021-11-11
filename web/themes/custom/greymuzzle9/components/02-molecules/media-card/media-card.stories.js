import cardTwig from './media-card.twig';
import mediaCardData from './media-card-left.yml';
import mediaCardVideoData from './media-card-video.yml';

export default {
  title: 'Paragraphs/Media Cards',
  argTypes: {
    cardDirection: {
      name: 'Direction',
      control: {
        type: 'select',
        options: ['left', 'right'],
      },
      defaultValue: 'left',
    },
  },
};

export const MediaCardLeft = ({ cardDirection }) => `
  <div class="story">
    ${cardTwig({
      ...mediaCardData,
      modifier: [cardDirection],
    })}
  </div>
`;
export const MediaCardVideo = () => cardTwig(mediaCardVideoData);
