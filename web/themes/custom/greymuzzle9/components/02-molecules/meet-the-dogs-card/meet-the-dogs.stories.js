import meet from './meet-the-dogs-card.twig';
import meetData from './meet-the-dogs-card.yml';

export default {
  title: 'Teasers/Meet The Dogs',
};

export const meetTheDogs = () => meet(meetData);
