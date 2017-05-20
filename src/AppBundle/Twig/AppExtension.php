<?php
namespace AppBundle\Twig;
class AppExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('somme', array($this, 'sommeFilter')),    
           new \Twig_SimpleFilter('percent', array($this, 'percentFilter')),
           new \Twig_SimpleFilter('percent', array($this, 'percentFrigoFilter')),
           new \Twig_SimpleFilter('percent', array($this, 'percentAfficheFilter')),
           new \Twig_SimpleFilter('percent', array($this, 'percentPotenceFilter')),
            new \Twig_SimpleFilter('count', array($this, 'countFilter')),
        );
    }


    public function sommeFilter($list, $attr,$default=0)
    {

        $somme=$default;
        foreach ($list as  $value) {
           $somme+=$value[$attr];
        }
        return $somme;
    }


    public function countFilter($list, $attr)
    {
        $count=0;
       foreach ($list as  $value) {
        if($value[0][$attr])
           $count+=1;
       }

        return $count;
    }

      public function percentFilter($list, $attr)
    {
        $somme=0;
       foreach ($list as  $value) {
        if($value[0][$attr])
           $somme+=1;
       }
        return count($list)>0?number_format($somme*100/count($list), 0, '.', ','):0;
    } 

      public function percentFrigoFilter($list,$marque)
    {
        $somme=0;
       foreach ($list as  $value) {
        switch ($marque) {
          case 'sminoff':
         if($value.getSminoffRed().getFrigo() ||$value.getSminoffBlack().getFrigo()||$value.getSminoffBlue().getFrigo() )
           $somme+=1;
            break;
           case 'heineken':
         if($value.getHeineken().getFrigo())
           $somme+=1;
            break; 
           case 'boostrer':
         if($value.getBoostrer().getFrigo())
           $somme+=1;
            break; 
          case 'voodka':
         if($value.getVoodka().getFrigo())
           $somme+=1;
            break; 
           case 'sabc1664':
         if($value.getSabc1664().getFrigo())
           $somme+=1;
            break; 
            case 'sabc':
         if($value.getSabc().getFrigo())
           $somme+=1;
            break;                                                    
          default:
            # code...
            break;
        }
       }
        return count($list)>0?number_format($somme*100/count($list), 0, '.', ','):0;
    } 


        public function percentPotenceFilter($list,$marque)
    {
        $somme=0;
       foreach ($list as  $value) {
        switch ($marque) {
          case 'sminoff':
         if($value.getSminoffRed().getPotence() ||$value.getSminoffBlack().getPotence()||$value.getSminoffBlue().getPotence() )
           $somme+=1;
            break;
           case 'heineken':
         if($value.getHeineken().getPotence() )
           $somme+=1;
            break; 
           case 'boostrer':
         if($value.getBoostrer().getPotence() )
           $somme+=1;
            break; 
          case 'voodka':
         if($value.getVoodka().getPotence() )
           $somme+=1;
            break; 
           case 'sabc1664':
         if($value.getSabc1664().getPotence() )
           $somme+=1;
            break; 
            case 'sabc':
         if($value.getSabc().getPotence())
           $somme+=1;
            break;                                                    
          default:
            # code...
            break;
        }
       }
        return count($list)>0?number_format($somme*100/count($list), 0, '.', ','):0;
    } 
    
    
      public function percentAfficheFilter($list,$marque)
    {
        $somme=0;
       foreach ($list as  $value) {
        switch ($marque) {
          case 'sminoff':
         if($value.getSminoffRed().getAffiche() ||$value.getSminoffBlack().getAffiche()||$value.getSminoffBlue().getAffiche() )
           $somme+=1;
            break;
           case 'heineken':
         if($value.getHeineken().getAffiche() )
           $somme+=1;
            break; 
           case 'boostrer':
         if($value.getBoostrer().getAffiche() )
           $somme+=1;
            break; 
          case 'voodka':
         if($value.getVoodka().getAffiche() )
           $somme+=1;
            break; 
           case 'sabc1664':
         if($value.getSabc1664().getAffiche() )
           $somme+=1;
            break; 
            case 'sabc':
         if($value.getSabc().getAffiche())
           $somme+=1;
            break;                                                    
          default:
            # code...
            break;
        }
       }
        return count($list)>0?number_format($somme*100/count($list), 0, '.', ','):0;
    }         
}