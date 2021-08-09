import program from './program.twig';
import programData from './program.yml';
import programDocs from './program.mdx';

export default {
  title: 'Molecules/Program Item',
  parameters: {
    docs: {
      page: programDocs,
    },
  },
};

export const ProgramItem = () => program(programData);
