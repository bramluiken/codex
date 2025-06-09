INSERT INTO weights (symptom_id, diagnosis_id, weight) VALUES
-- Symptom 1: Trouble concentrating
(1, 1, 2),   -- concentration issues contribute to Depression:contentReference[oaicite:19]{index=19}
(1, 2, 2),   -- concentration difficulty is common in Generalized Anxiety:contentReference[oaicite:20]{index=20}
(1, 3, 2),   -- also occurs in PTSD (difficulty concentrating during hyperarousal):contentReference[oaicite:21]{index=21}
(1, 5, 3),   -- a core symptom of ADHD is poor focus (high weight):contentReference[oaicite:22]{index=22}
(1, 6, 2),   -- occurs during manic episodes (distractibility in Bipolar):contentReference[oaicite:23]{index=23}

-- Symptom 2: Persistent sad/down mood
(2, 1, 3),   -- depressed mood is defining for Major Depressive Disorder:contentReference[oaicite:24]{index=24}
(2, 3, 1),   -- can appear in PTSD (negative emotional state):contentReference[oaicite:25]{index=25}
(2, 6, 2),   -- bipolar patients also experience depressive episodes:contentReference[oaicite:26]{index=26}

-- Symptom 3: Loss of interest or pleasure (anhedonia)
(3, 1, 3),   -- anhedonia is a key symptom of Depression:contentReference[oaicite:27]{index=27}
(3, 3, 2),   -- occurs in PTSD (diminished interest in activities):contentReference[oaicite:28]{index=28}
(3, 6, 2),   -- appears in Bipolar depressive phases:contentReference[oaicite:29]{index=29}
(3, 7, 2),   -- negative symptom in Schizophrenia (flat affect/avolition):contentReference[oaicite:30]{index=30}

-- Symptom 4: Hopelessness about the future
(4, 1, 2),   -- common in Depression (hopeless/helpless feelings):contentReference[oaicite:31]{index=31}
(4, 3, 1),   -- can occur in PTSD (negative outlook after trauma):contentReference[oaicite:32]{index=32}
(4, 6, 2),   -- also present in Bipolar depressive episodes:contentReference[oaicite:33]{index=33}

-- Symptom 5: Excessive guilt or self-blame
(5, 1, 3),   -- excessive guilt is a classic depressive symptom:contentReference[oaicite:34]{index=34}
(5, 3, 2),   -- survivors’ guilt or self-blame occurs in PTSD:contentReference[oaicite:35]{index=35}

-- Symptom 6: Frequent thoughts of death or suicide
(6, 1, 3),   -- suicidal ideation is a critical Depression symptom:contentReference[oaicite:36]{index=36}
(6, 3, 1),   -- often co-occurs in severe PTSD (though not diagnostic criterion)

-- Symptom 7: Chronic anxiety/worry
(7, 2, 3),   -- excessive worry is the hallmark of GAD:contentReference[oaicite:37]{index=37}:contentReference[oaicite:38]{index=38}
(7, 3, 1),   -- PTSD patients may have constant anxiety/fear:contentReference[oaicite:39]{index=39}
(7, 9, 1),   -- panic disorder patients worry about future panic attacks

-- Symptom 8: Sudden panic attacks (intense fear episodes)
(8, 9, 3),   -- defining feature of Panic Disorder (recurrent panic attacks)
(8, 3, 2),   -- PTSD can involve panic episodes when triggered:contentReference[oaicite:40]{index=40}
(8, 8, 2),   -- people with Social Anxiety may have panic attacks in social situations:contentReference[oaicite:41]{index=41}

-- Symptom 9: Avoidance of places/situations due to anxiety
(9, 3, 3),   -- PTSD: active avoidance of trauma reminders is core:contentReference[oaicite:42]{index=42}
(9, 9, 3),   -- Panic Disorder: may avoid places where escape/help is hard (agoraphobia)
(9, 4, 2),   -- OCD: may avoid triggers of obsessions (e.g. dirt, risky objects)

-- Symptom 10: Avoiding social activities for fear of embarrassment
(10, 8, 3),  -- hallmark of Social Anxiety Disorder (avoiding social interactions):contentReference[oaicite:43]{index=43}
(10, 2, -2), -- NOT typical of GAD (social avoidance points more to social phobia than general worry)

-- Symptom 11: Flashbacks or nightmares of trauma
(11, 3, 3),  -- classic re-experiencing symptom of PTSD:contentReference[oaicite:44]{index=44}
(11, 2, -2), -- flashbacks are not seen in ordinary anxiety disorders (negative for GAD)
(11, 4, -1), -- not an OCD phenomenon (intrusive thoughts in OCD are not trauma flashbacks)

-- Symptom 12: Hypervigilance (on guard, easily startled)
(12, 3, 3),  -- PTSD hyperarousal symptom:contentReference[oaicite:45]{index=45}
(12, 2, 1),  -- also seen to a lesser extent in GAD (chronic “keyed up” tension):contentReference[oaicite:46]{index=46}

-- Symptom 13: Emotional numbness or detachment
(13, 3, 3),  -- feeling detached/numb is common in PTSD (negative mood):contentReference[oaicite:47]{index=47}
(13, 1, 2),  -- can occur in Depression (feeling empty or apathetic):contentReference[oaicite:48]{index=48}
(13, 7, 2),  -- also in Schizophrenia (blunted affect, social withdrawal):contentReference[oaicite:49]{index=49}

-- Symptom 14: Unwanted intrusive thoughts
(14, 4, 3),  -- hallmark obsessions in OCD:contentReference[oaicite:50]{index=50}
(14, 2, 2),  -- GAD involves uncontrollable worry thoughts:contentReference[oaicite:51]{index=51}
(14, 3, 2),  -- PTSD includes intrusive distressing memories:contentReference[oaicite:52]{index=52}

-- Symptom 15: Compulsive rituals to reduce anxiety
(15, 4, 3),  -- defining feature of OCD (compulsions/rituals):contentReference[oaicite:53]{index=53}
(15, 2, -2), -- such rituals are *not* present in GAD (negative weight for GAD)

-- Symptom 16: Repeated checking of locks/appliances
(16, 4, 3),  -- a common compulsion in OCD (checking behavior)
(16, 3, 1),  -- also seen in PTSD (safety checking after trauma, e.g. repeatedly checking locks)
(16, 2, 1),  -- occasionally in anxiety (some worriers double-check things)

-- Symptom 17: Disorganization (difficulty organizing tasks/belongings)
(17, 5, 3),  -- classic ADHD symptom (disorganized, messy, poor time management):contentReference[oaicite:54]{index=54}
(17, 1, 1),  -- can occur in Depression (low energy or motivation to stay organized)

-- Symptom 18: Inability to sit still, restlessness
(18, 5, 3),  -- core hyperactivity symptom of ADHD:contentReference[oaicite:55]{index=55}
(18, 2, 2),  -- common in anxiety (restless, keyed up):contentReference[oaicite:56]{index=56}
(18, 6, 2),  -- seen in Bipolar mania (psychomotor agitation/increased activity):contentReference[oaicite:57]{index=57}

-- Symptom 19: Impulsivity (acting without thinking)
(19, 5, 3),  -- major symptom of ADHD (impulsive behavior):contentReference[oaicite:58]{index=58}
(19, 6, 3),  -- common in Bipolar (manic impulsivity – spending, reckless acts):contentReference[oaicite:59]{index=59}
(19, 3, 1),  -- can appear in PTSD (reckless/self-destructive behaviors in hyperarousal):contentReference[oaicite:60]{index=60}
(19, 4, -2), -- **negative** for OCD (OCD patients are generally cautious/deliberate, opposite of impulsive)
(19, 2, -1), -- **negative** for GAD (chronic worriers tend to overthink rather than act rashly)
(19, 10, -1), -- **negative** for Anorexia (anorexia involves extreme self-control, not impulsivity)

-- Symptom 20: Episodes of feeling extremely “high” or energetic for days
(20, 6, 3),  -- hallmark of Bipolar mania (elevated mood/state for days):contentReference[oaicite:61]{index=61}
(20, 1, -3), -- **negative** for MDD (such manic highs do not occur in unipolar depression)
(20, 2, -1), -- **negative** for GAD (mania-like euphoria is not part of anxiety disorders)

-- Symptom 21: Little need for sleep yet full of energy
(21, 6, 3),  -- classic manic symptom in Bipolar (decreased need for sleep):contentReference[oaicite:62]{index=62}
(21, 1, -2), -- **negative** for MDD (depressed insomnia comes with fatigue, not high energy)
(21, 2, -1), -- **negative** for GAD (anxious insomnia leaves one tired, not energetic)

-- Symptom 22: Hearing voices or seeing things (hallucinations)
(22, 7, 3),  -- core psychotic symptom of Schizophrenia:contentReference[oaicite:63]{index=63}
(22, 6, 2),  -- can occur in severe Bipolar (psychotic features in mania or depression):contentReference[oaicite:64]{index=64}
(22, 2, -2), -- **negative** for GAD (hallucinations indicate psychosis, not anxiety)
(22, 4, -2), -- **negative** for OCD (OCD intrusive thoughts are self-generated, not perceived as external voices)
(22, 5, -2), -- **negative** for ADHD (hallucinations are not associated with ADHD)

-- Symptom 23: Delusional beliefs (e.g. paranoid belief of being spied on)
(23, 7, 3),  -- delusions are a defining symptom of Schizophrenia:contentReference[oaicite:65]{index=65}
(23, 6, 2),  -- can appear in Bipolar (e.g. grandiose or paranoid delusions during mania):contentReference[oaicite:66]{index=66}
(23, 2, -2), -- **negative** for GAD (persistent false beliefs are not part of anxiety disorders)
(23, 4, -2), -- **negative** for OCD (OCD patients usually recognize their obsessions aren’t true, unlike delusions)
(23, 5, -2), -- **negative** for ADHD (delusional beliefs are unrelated to ADHD)

-- Symptom 24: Restricting food intake due to fear of weight gain
(24, 10, 3), -- defining behavior in Anorexia Nervosa (extreme dieting from intense weight-gain fear):contentReference[oaicite:67]{index=67}
(24, 1, -2), -- **negative** for Depression (loss of appetite in depression is not driven by fear of weight gain)

-- Symptom 25: Feeling overweight despite being underweight (body image distortion)
(25, 10, 3), -- hallmark cognitive symptom of Anorexia (distorted body image):contentReference[oaicite:68]{index=68}
(25, 1, -1),  -- **negative** for Depression (not typical to have this specific body-image delusion in depression)

-- Symptom 26: Frequent fatigue or low energy
(26, 1, 3),  -- fatigue/loss of energy nearly every day in Depression:contentReference[oaicite:69]{index=69}
(26, 2, 2),  -- common in GAD (being easily fatigued from chronic worry):contentReference[oaicite:70]{index=70}
(26, 3, 2),  -- present in PTSD (sleep problems and stress lead to fatigue):contentReference[oaicite:71]{index=71}
(26, 10, 2), -- common in Anorexia (physical weakness from malnutrition)

-- Symptom 27: Insomnia or trouble sleeping
(27, 2, 2),  -- difficulty sleeping is a symptom of GAD (due to anxiety at night):contentReference[oaicite:72]{index=72}
(27, 1, 2),  -- sleep disturbance (insomnia or hypersomnia) in Depression:contentReference[oaicite:73]{index=73}
(27, 3, 2),  -- part of PTSD hyperarousal (insomnia and nightmares):contentReference[oaicite:74]{index=74}

-- Symptom 28: Irritability or frequent anger over little things
(28, 2, 2),  -- irritability is often seen in GAD (especially when anxious or tired):contentReference[oaicite:75]{index=75}
(28, 3, 3),  -- PTSD hyperarousal includes irritability/anger outbursts:contentReference[oaicite:76]{index=76}
(28, 1, 2),  -- depression can present with irritability (notably in children/teens or atypical cases):contentReference[oaicite:77]{index=77}
(28, 6, 3),  -- bipolar mania frequently manifests as extreme irritability (when not euphoric):contentReference[oaicite:78]{index=78}
(28, 5, 1),  -- ADHD individuals may get easily frustrated or short-tempered (though not a core diagnostic criterion)

-- Symptom 29: Racing thoughts that are hard to keep up with
(29, 6, 3),  -- classic in Bipolar mania (flight of ideas/racing thoughts):contentReference[oaicite:79]{index=79}
(29, 2, 1),  -- can occur in anxiety (rapid anxious thoughts), e.g. during panic or acute worry

-- Symptom 30: Episodes of excessive spending or risky behavior “out of character”
(30, 6, 3),  -- hallmark of Bipolar manic episodes (reckless spending, sexual indiscretions, etc.):contentReference[oaicite:80]{index=80}
(30, 5, 2),  -- impulsive overspending or risk-taking can also occur in ADHD (poor impulse control)
(30, 3, 1),  -- PTSD can involve reckless, self-destructive behaviors (e.g. substance abuse, reckless driving):contentReference[oaicite:81]{index=81}
(30, 4, -1); -- **negative** for OCD (people with OCD are generally risk-averse and behavior is overly cautious)
