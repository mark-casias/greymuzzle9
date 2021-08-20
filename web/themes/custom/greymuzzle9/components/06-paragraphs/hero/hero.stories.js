import hero from './hero.twig';
import heroData from './hero.yml';

export default {
  title: 'Paragraphs/Hero Image',
};

export const HeroImage = () => hero(heroData);
