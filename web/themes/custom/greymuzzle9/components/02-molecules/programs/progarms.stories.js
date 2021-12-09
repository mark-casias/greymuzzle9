import paragraph from './programs.twig';
import paragraphData from './programs.yml';

export default {
  title: 'Paragraphs/Programs',
};

export const Programs = () => paragraph(paragraphData);
