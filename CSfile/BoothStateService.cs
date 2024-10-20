public class BoothStateService
{
    public string? BoothNumber { get; private set; }
    public string? Step3Data { get; set; }
    public string? Step4Data { get; set; }
    public string? Step5Data { get; set; }

    public void SetBoothNumber(string? number)
    {
        BoothNumber = number;
    }
}