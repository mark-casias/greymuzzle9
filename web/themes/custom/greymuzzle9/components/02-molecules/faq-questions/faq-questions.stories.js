import faqTwig from './faq-questions.twig';
import faqData from './faq-questions.yml';

export default {
  title: 'Paragraphs/FAQ Questions',
};

export const FAQQuestions = () => faqTwig(faqData);
