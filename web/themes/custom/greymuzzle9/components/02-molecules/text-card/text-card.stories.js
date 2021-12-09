import textCardTwig from './text-card.twig';
import textCardData from './text-card.yml';

export default {
  title: 'Paragraphs/Text Card',
};

export const TextCard = () => textCardTwig(textCardData);
