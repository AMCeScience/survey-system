<?php

$config['progress'] = [
  'start' => 0,
  'prefill_check' => 25,
  'question_lists' => 75
];

$config['generic_questions'] = [
  '1' => [
    'name' => 'informed',
    'type' => 'checkbox',
    'question' => 'How do you keep yourself informed about available tools?',
    'answers' => [
      '1' => 'Through my organisation (e.g. employer, project)',
      '2' => 'Through colleagues in my organisation',
      '3' => 'Through my peers (e.g. web forums/conferences/scientific papers)',
      '4' => 'Through school/training',
      '5' => 'Through newsletter/advertisement',
      '6' => 'Through periodic searches (e.g. web)'
    ],
    'other' => true
  ],
  '2' => [
    'name' => 'literate',
    'type' => 'scale',
    'question' => 'How literate do you consider yourself about technology-assisted systematic reviews?',
    'answers' => 7,
    'labels' => [
      'min' => 'Not literate',
      'max' => 'Very literate'
    ],
    'other' => false
  ],
  '3' => [
    'name' => 'fits_workflow',
    'type' => 'checkbox',
    'question' => 'How do you determine which task(s) a tool performs and whether it fits your workflow?',
    'answers' => [
      '1' => 'I read the user documentation',
      '2' => 'I read information about the tool (e.g. tool\'s website)',
      '3' => 'I get information from colleagues/peers',
      '4' => 'I read scientific literature',
      '5' => 'I try the software',
      '6' => 'I follow courses/training'
    ],
    'other' => true
  ],
  '4' => [
    'name' => 'fit_effort',
    'type' => 'scale',
    'question' => 'How much effort does it take to determine which task(s) a tool performs and whether it fits in your workflow?',
    'answers' => 7,
    'labels' => [
      'min' => 'It takes little effort',
      'max' => 'It takes a large effort'
    ],
    'other' => false
  ],
  // Sliders with a certain maximum
  '5' => [
    'name' => 'difficult_aspects',
    'type' => 'checkbox',
    'question' => 'Which aspects mostly contribute to the effort to determine which task(s) a tool performs and whether it fits in your workflow?',
    'answers' => [
      '1' => 'The quality of the user documentation',
      '2' => 'Information about the tool (e.g. tool\'s website)',
      '3' => 'My colleagues/peers using it',
      '4' => 'The availability of scientific literature about the tool',
      '5' => 'My own experience with the tool'
    ],
    'other' => true
  ],
  '6' => [
    'name' => 'assessing',
    'type' => 'scale',
    'question' => 'Which is most important when assessing a tool?',
    'answers' => 7,
    'labels' => [
      'min' => 'The tasks a tool performs',
      'max' => 'Whether it fits in my workflow'
    ],
    'other' => false
  ],
  '7' => [
    'name' => 'necessity_start',
    'type' => 'checkbox',
    'question' => 'What is necessary for you to start using a new tool?',
    'answers' => [
      '1' => 'It addresses a barrier in my workflow',
      '2' => 'It decreases project time',
      '3' => 'It has reproducible results',
      '4' => 'It facilitates collaboration with colleagues',
      '5' => 'It facilitates remote collaboration with colleagues',
      '6' => 'It contains (extensive) user documentation',
      '7' => 'There is scientific underpinning of method/algorithm',
      '8' => 'I can understand what it does',
      '9' => 'The result is useful for my job',
      '10' => 'My colleagues/peers use it',
      '11' => 'I get support when using it'
    ],
    'other' => true
  ],
  '8' => [
    'name' => 'consider_past',
    'type' => 'radio',
    'question' => 'Are there tools that you have used in the past, but that you currently don\'t use?',
    'answers' => [
      'yes' => 'Yes',
      'no' => 'No'
    ],
    'other' => false,
    'follow_up' => 'why_not'
  ],
  '9' => [
    'is_follow_up' => true,
    'name' => 'why_not',
    'type' => 'checkbox',
    'question' => 'Why don\'t you use these tools anymore?',
    'answers' => [
      '1' => 'They were lacking (expected) functionality',
      '2' => 'They had poor usability',
      '3' => 'They had steep learning curve',
      '4' => 'They were lacking support from colleagues or organisation',
      '5' => 'They were lacking user documentation',
      '6' => 'They didn\'t fit my current workflow',
      '7' => 'I couldn\'t trust results/output',
      '8' => 'I couldn\'t obtain licensing'
    ],
    'other' => true
  ],
  '10' => [
    'name' => 'like_to_use',
    'type' => 'radio',
    'question' => 'Are there tools you would like to use but don\'t?',
    'answers' => [
      'yes' => 'Yes',
      'no' => 'No'
    ],
    'other' => false,
    'follow_up' => 'why_cant'
  ],
  '11' => [
    'is_follow_up' => true,
    'name' => 'why_cant',
    'type' => 'checkbox',
    'question' => 'Why don\'t you use these tools?',
    'answers' => [
      '1' => 'They lack (expected) functionality',
      '2' => 'They have poor usability',
      '3' => 'They have a steep learning curve',
      '4' => 'They lack support from colleagues or organisation',
      '5' => 'They lack user documentation',
      '6' => 'They don\'t fit current workflow',
      '7' => 'I can\'t trust results/output',
      '8' => 'I can\'t obtain licensing'
    ],
    'other' => true
  ],
  '12' => [
    'name' => 'affect',
    'type' => 'scale',
    'question' => 'In which way do systematic review automation tools impact your systematic reviews?',
    'answers' => 7,
    'labels' => [
      'min' => 'In a negative way',
      'max' => 'In a postive way'
    ],
    'other' => false
  ],
  '13' => [
    'name' => 'stay_informed',
    'type' => 'radio',
    'question' => 'Would you like to stay informed about the results of the questionnaire?',
    'answers' => [
      'yes' => 'Yes',
      'no' => 'No'
    ],
    'other' => false,
  ],
];

$config['specific_questions'] = [
  '1' => [
    'name' => 'hear_tool',
    'type' => 'checkbox',
    'question' => 'How did you hear about this tool?',
    'answers' => [
      '1' => 'Through my organisation',
      '2' => 'Through colleagues in my organisation',
      '3' => 'Through my peers (e.g. web forums/conferences/scientific papers)',
      '4' => 'Through school/training',
      '5' => 'Through newsletter/advertisement',
      '6' => 'Through searches (e.g. web)',
    ],
    'other' => true
  ],
  '2' => [
    'name' => 'used_peers',
    'type' => 'scale',
    'question' => 'Is the tool commonly used by your peers?',
    'answers' => 7,
    'labels' => [
      'min' => 'None of my peers use this tool',
      'max' => 'All my peers use this tool'
    ],
    'other' => false
  ],
  '3' => [
    'name' => 'tasks_used',
    'type' => 'checkbox',
    'question' => 'For which task(s) are you currently using this tool?',
    'answers' => [
      '1' => 'Searching',
      '2' => 'Duplicate removal',
      '3' => 'Selection',
      '4' => 'Data extraction',
      '5' => 'Risk of bias',
      '6' => 'Evidence synthesis (quantitative/qualitative)',
      '7' => 'Data tracking/provenance',
      '8' => '(Remote) collaboration',
    ],
    'other' => true
  ],
  '4' => [
    'name' => 'other_tools_same',
    'type' => 'radio',
    'question' => 'Are there other tools available that do the same task?',
    'answers' => [
      'yes' => 'Yes',
      'no' => 'No',
      'unknown' => 'Don\'t know'
    ],
    'other' => false,
    'follow_up' => 'why_not_same'
  ],
  '5' => [
    'is_follow_up' => true,
    'name' => 'why_not_same',
    'type' => 'checkbox',
    'question' => 'Why have you not chosen for the other tool(s)?',
    'answers' => [
      '1' => 'It is not supported by organisation',
      '2' => 'There are licensing costs',
      '3' => 'It is more difficult to use',
      '4' => 'It is less well integrated in my workflow',
      '5' => 'It is lacking documentation',
      '6' => 'It is lacking scientific underpinning of method/algorithm',
      '7' => 'I don’t trust the results',
      '8' => 'The tool does not explain to me how it generates the results',
      '9' => 'The results are not as usable in my workflow',
      '10' => 'My colleagues don’t use it',
    ],
    'other' => true
  ],
  '6' => [
    'name' => 'why_tool',
    'type' => 'checkbox',
    'question' => 'Why do you use this tool?',
    'answers' => [
      '1' => 'My colleagues use it',
      '2' => 'I am obliged by my organisation',
      '3' => 'It is supported by my organisation',
      '4' => 'My organisation has a license',
      '5' => 'It is free to use',
      '6' => 'It is easy to install',
      '7' => 'It is available as an online service (e.g. cloud, in browser)',
      '8' => 'It is well integrated into my workflow',
      '9' => 'It is easy to use',
      '10' => 'There is training available (tutorials/videos)',
      '11' => 'There is good documentation available',
      '12' => 'It delivers what it promises',
      '13' => 'It does what I need',
      '14' => 'I trust the results',
    ],
    'other' => true
  ],
  '7' => [
    'name' => 'why_trust',
    'type' => 'checkbox',
    'question' => 'How did you assess the quality of the results?',
    'answers' => [
      '1' => 'I did not assess the quality',
      '2' => 'Scientific underpinning of the method/algorithm is available',
      '3' => 'Documentation is available',
      '4' => 'I have performed an evaluation of the results',
      '5' => 'Through experience of colleagues',
      '6' => 'The tool explains to me how it generated the result',
      '7' => 'I analysed at the code',
      '8' => 'I contacted the developers'
    ],
    'other' => true
  ],
  '8' => [
    'name' => 'increase_productivity',
    'type' => 'scale',
    'question' => 'How does the tool impact your productivity?',
    'answers' => 7,
    'labels' => [
      'min' => 'My job takes less time',
      'max' => 'My job takes more time'
    ],
    'other' => false
  ],
  '9' => [
    'name' => 'increase_performance',
    'type' => 'scale',
    'question' => 'How does the tool impact the quality of your work?',
    'answers' => 7,
    'labels' => [
      'min' => 'My results are worse',
      'max' => 'I get better results'
    ],
    'other' => false
  ],
  '10' => [
    'name' => 'tool_experience',
    'type' => 'scale',
    'question' => 'How much experience do you have with this tool?',
    'answers' => 7,
    'labels' => [
      'min' => 'I\'m a beginner',
      'max' => 'I\'m an expert'
    ],
    'other' => false
  ],
  '11' => [
    'name' => 'voluntary_use',
    'type' => 'radio',
    'question' => 'Do you use this tool by your own choice?',
    'answers' => [
      'free' => 'I use this tool by my own choice',
      'organisation' => 'I am required by my organisation to use this tool',
      'peers' => 'I am required by my peers to use this tool',
      'publisher' => 'I am required by my publisher to use this tool'
    ],
    'other' => true,
    'follow_up' => false
  ],
];

$config['usability_questions'] = [
  '1' => [
    'name' => 'sus_1',
    'type' => 'scale',
    'question' => 'I like to use this tool',
    'answers' => 5,
    'labels' => [
      'min' => 'Strongly disagree',
      'max' => 'Strongly agree'
    ],
    'other' => false
  ],
  '2' => [
    'name' => 'sus_2',
    'type' => 'scale',
    'question' => 'I find this tool unnecessarily complex',
    'answers' => 5,
    'labels' => [
      'min' => 'Strongly disagree',
      'max' => 'Strongly agree'
    ],
    'other' => false
  ],
  '3' => [
    'name' => 'sus_3',
    'type' => 'scale',
    'question' => 'I think this tool is easy to use',
    'answers' => 5,
    'labels' => [
      'min' => 'Strongly disagree',
      'max' => 'Strongly agree'
    ],
    'other' => false
  ],
  '4' => [
    'name' => 'sus_4',
    'type' => 'scale',
    'question' => 'I need(ed) the support of a technical person to be able to use this tool',
    'answers' => 5,
    'labels' => [
      'min' => 'Strongly disagree',
      'max' => 'Strongly agree'
    ],
    'other' => false
  ],
  '5' => [
    'name' => 'sus_5',
    'type' => 'scale',
    'question' => 'I find that various functions in this tool are well integrated',
    'answers' => 5,
    'labels' => [
      'min' => 'Strongly disagree',
      'max' => 'Strongly agree'
    ],
    'other' => false
  ],
  '6' => [
    'name' => 'sus_6',
    'type' => 'scale',
    'question' => 'I think there is too much inconsistency in this tool',
    'answers' => 5,
    'labels' => [
      'min' => 'Strongly disagree',
      'max' => 'Strongly agree'
    ],
    'other' => false
  ],
  '7' => [
    'name' => 'sus_7',
    'type' => 'scale',
    'question' => 'I would imagine that most people would learn to use this tool very quickly',
    'answers' => 5,
    'labels' => [
      'min' => 'Strongly disagree',
      'max' => 'Strongly agree'
    ],
    'other' => false
  ],
  '8' => [
    'name' => 'sus_8',
    'type' => 'scale',
    'question' => 'I find the tool very cumbersome to use',
    'answers' => 5,
    'labels' => [
      'min' => 'Strongly disagree',
      'max' => 'Strongly agree'
    ],
    'other' => false
  ],
  '9' => [
    'name' => 'sus_9',
    'type' => 'scale',
    'question' => 'I feel very confident using this tool',
    'answers' => 5,
    'labels' => [
      'min' => 'Strongly disagree',
      'max' => 'Strongly agree'
    ],
    'other' => false
  ],
  '10' => [
    'name' => 'sus_10',
    'type' => 'scale',
    'question' => 'I needed to learn a lot of things before I could get going with this tool',
    'answers' => 5,
    'labels' => [
      'min' => 'Strongly disagree',
      'max' => 'Strongly agree'
    ],
    'other' => false
  ],
];