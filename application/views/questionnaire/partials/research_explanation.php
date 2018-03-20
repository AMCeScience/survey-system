<p>
  The aim of this research is to gain insight in the usage of, and the experience with,
  computer tools, programs, and software that automate (parts of) the systematic review process.
  In the context of this questionnaire, we refer to these simply as <span class="text-info">automation tools</span>.
</p>

<p>
  The results of this research will support the systematic review community in making informed
  decisions about which automation tools to consider. The first questionnaire collected general characteristics
  about the community, such as how many reviews are done on average and which tools are used.
  Through this second questionnaire we attempt to understand the reasoning behind the use of automation tools.
  This involves the decision-making process and usage behavior,
  therefore you will be asked about your experiences with choosing and using these tools.
</p>

<p>
  This follow-up questionnaire is composed of two parts. We first ask you to update some of your answers to the first
  questionnaire, then we will ask you general questions about how you choose and assess (new) tools.
  <?php if ($user_type === 'using') { ?>
    Finally, we ask you specific questions about one of the tools that you use (or consider to use).
    The first tool is predefined by the questionnaire, however at the end you may choose to answer the
    questions about additional tools of your own choosing.
  <?php } ?>
</p>

<p class="font-weight-bold">
  <?php $duration = ($user_type !== 'using' ? '5 to 10 minutes' : '15 to 20 minutes') ?>

  This questionnaire will take approximately <?php echo $duration; ?> to complete.
  You can pause and continue the questionnaire at any point, answers will be stored between sessions.
  As part of the write-up, anonymous results will be published.
</p>

<p>
  If you have any questions, please contact me at: <a href="email:a.j.vanaltena@amc.uva.nl">a.j.vanaltena@amc.uva.nl</a>
</p>