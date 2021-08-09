import card from './media-card.twig';
import mediaCardLeftData from './media-card-left.yml';
import mediaCardRightData from './media-card-right.yml';
import mediaCardVideoData from './media-card-video.yml';

export default {
  title: 'Paragraphs/Media Cards',
};

export const MediaCardLeft = () => card(mediaCardLeftData);
export const MediaCardRight = () => card(mediaCardRightData);
export const MediaCardVideo = () => card(mediaCardVideoData);
